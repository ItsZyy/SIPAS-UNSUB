<?php

namespace App\Http\Requests;

use App\Models\SystemSetting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ArchiveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('document_date')) {
            $date = $this->input('document_date');

            if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $date, $matches)) {
                $this->merge([
                    'document_date' => sprintf('%04d-%02d-%02d', $matches[3], $matches[2], $matches[1]),
                ]);
            }
        }

        // Log detail upload file untuk debugging jika ada file
        if ($this->hasFile('file')) {
            $file = $this->file('file');
            Log::info('Upload file diterima', [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
                'is_valid' => $file->isValid(),
                'php_error' => $file->getError(),
                'php_error_msg' => $this->phpUploadErrorMessage($file->getError()),
                'server_limits' => [
                    'upload_max_filesize' => ini_get('upload_max_filesize'),
                    'post_max_size' => ini_get('post_max_size'),
                    'memory_limit' => ini_get('memory_limit'),
                ],
                'app_max_size_mb' => SystemSetting::getValue('max_file_size', '25'),
            ]);
        }
    }

    public function rules(): array
    {
        $rules = [
            'category_id' => ['required', 'exists:categories,id'],
            'document_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('archives')->ignore($this->route('archive')),
            ],
            'title' => ['required', 'string', 'max:255'],
            'document_date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
        ];

        // Ambil max_file_size dari database (dalam MB), konversi ke KB untuk Laravel validation
        // Database menyimpan dalam MB, Laravel rule 'max' menggunakan KB
        $maxSizeMB = (int) SystemSetting::getValue('max_file_size', '25');
        $maxSizeKB = $maxSizeMB * 1024;

        $fileRules = ['mimes:pdf', 'max:' . $maxSizeKB];

        if ($this->isMethod('POST')) {
            $rules['file'] = array_merge(['required'], $fileRules);
        } else {
            $rules['file'] = array_merge(['nullable'], $fileRules);
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'file.max' => sprintf(
                'Ukuran file melebihi batas maksimum aplikasi (%s MB). Silakan periksa pengaturan "Ukuran Maksimum Upload PDF" di Pengaturan Sistem.',
                SystemSetting::getValue('max_file_size', '25')
            ),
            'file.mimes' => 'File yang diupload harus berformat PDF.',
        ];

        $file = $this->file('file');
        if ($file && !$file->isValid()) {
            $errorCode = $file->getError();
            $msg = $this->phpUploadErrorMessage($errorCode);

            Log::warning('[UPLOAD] PHP menolak upload', array_merge(
                $this->serverLimitInfo(),
                [
                    'error_code' => $errorCode,
                    'error_message' => $msg,
                    'filename' => $file->getClientOriginalName(),
                    'app_max_size_mb' => SystemSetting::getValue('max_file_size', '25'),
                ]
            ));

            $messages['file.uploaded'] = $msg;
        }

        return $messages;
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $file = $this->file('file');
            if ($file && !$file->isValid()) {
                $errorCode = $file->getError();
                $msg = $this->phpUploadErrorMessage($errorCode);

                if (!collect($validator->errors()->get('file'))->contains(function ($e) use ($msg) {
                    return str_contains($e, $msg);
                })) {
                    $validator->errors()->add('file', $msg);
                }
            }

            // Jika file valid tetapi ada error lain, log perbandingan limit
            if ($file && $file->isValid()) {
                $appMB = (int) SystemSetting::getValue('max_file_size', '25');
                $phpMB = $this->iniToMB(ini_get('upload_max_filesize'));
                if ($appMB > $phpMB) {
                    Log::warning('[UPLOAD] Setting aplikasi melebihi batas server', $this->serverLimitInfo());
                }
            }
        });
    }

    private function phpUploadErrorMessage(int $code): string
    {
        $map = [
            UPLOAD_ERR_INI_SIZE => sprintf(
                'Batas server: upload_max_filesize = %s, post_max_size = %s.' . "\n" .
                'Solusi: naikkan nilai upload_max_filesize di php.ini, atau gunakan file yang lebih kecil.',
                ini_get('upload_max_filesize'),
                ini_get('post_max_size')
            ),
            UPLOAD_ERR_FORM_SIZE => 'Batas form: ukuran file melebihi nilai MAX_FILE_SIZE pada form.',
            UPLOAD_ERR_PARTIAL => 'File hanya terupload sebagian. Silakan coba upload ulang.',
            UPLOAD_ERR_NO_FILE => 'Tidak ada file yang dipilih untuk diupload.',
            UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary server tidak ditemukan. Hubungi administrator.',
            UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk server. Hubungi administrator.',
            UPLOAD_ERR_EXTENSION => 'Upload file dihentikan oleh ekstensi PHP yang terpasang.',
        ];

        return $map[$code] ?? 'Terjadi error tidak diketahui (kode: ' . $code . '). Hubungi administrator.';
    }

    private function serverLimitInfo(): array
    {
        return [
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'memory_limit' => ini_get('memory_limit'),
            'app_setting_mb' => SystemSetting::getValue('max_file_size', '25'),
        ];
    }

    private function iniToMB(string $value): int
    {
        $value = trim($value);
        $unit = strtoupper(substr($value, -1));
        $num = (int) $value;
        return match ($unit) {
            'G' => $num * 1024,
            'M' => $num,
            'K' => (int) round($num / 1024),
            default => (int) round($num / 1024 / 1024),
        };
    }
}
