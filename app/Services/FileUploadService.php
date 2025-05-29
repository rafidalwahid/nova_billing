<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Allowed file types for ticket attachments.
     */
    const ALLOWED_TYPES = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'text/plain',
        'application/zip',
        'application/x-zip-compressed',
    ];

    /**
     * Maximum file size in bytes (10MB).
     */
    const MAX_FILE_SIZE = 10 * 1024 * 1024;

    /**
     * Upload a file for a ticket attachment.
     *
     * @param UploadedFile $file
     * @param int $ticketId
     * @return array
     * @throws \InvalidArgumentException
     */
    public function uploadTicketAttachment(UploadedFile $file, int $ticketId): array
    {
        // Validate file
        $this->validateFile($file);

        // Generate unique filename
        $fileName = $this->generateFileName($file);

        // Store file
        $filePath = $file->storeAs(
            "ticket-attachments/{$ticketId}",
            $fileName,
            'public'
        );

        if (!$filePath) {
            throw new \RuntimeException('Failed to upload file');
        }

        return [
            'original_name' => $file->getClientOriginalName(),
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_at' => now()->toISOString(),
            'download_url' => Storage::disk('public')->url($filePath),
        ];
    }

    /**
     * Validate uploaded file.
     *
     * @param UploadedFile $file
     * @throws \InvalidArgumentException
     */
    private function validateFile(UploadedFile $file): void
    {
        // Check if file is valid
        if (!$file->isValid()) {
            throw new \InvalidArgumentException('Invalid file upload');
        }

        // Check file size
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new \InvalidArgumentException('File size exceeds 10MB limit');
        }

        // Check file type
        if (!in_array($file->getMimeType(), self::ALLOWED_TYPES)) {
            throw new \InvalidArgumentException('File type not allowed. Allowed types: JPG, PNG, PDF, DOC, DOCX, TXT, ZIP');
        }
    }

    /**
     * Generate a unique filename.
     *
     * @param UploadedFile $file
     * @return string
     */
    private function generateFileName(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Sanitize filename
        $baseName = Str::slug($baseName);

        // Add timestamp and random string for uniqueness
        return time() . '_' . Str::random(8) . '_' . $baseName . '.' . $extension;
    }

    /**
     * Delete a ticket attachment file.
     *
     * @param string $filePath
     * @return bool
     */
    public function deleteTicketAttachment(string $filePath): bool
    {
        return Storage::disk('public')->delete($filePath);
    }

    /**
     * Get file information for an attachment.
     *
     * @param array $attachment
     * @return array
     */
    public function getAttachmentInfo(array $attachment): array
    {
        $filePath = $attachment['file_path'] ?? null;
        $exists = $filePath ? Storage::disk('public')->exists($filePath) : false;

        return [
            'original_name' => $attachment['original_name'] ?? 'Unknown',
            'file_name' => $attachment['file_name'] ?? 'Unknown',
            'file_size' => $attachment['file_size'] ?? 0,
            'file_size_human' => self::formatFileSize($attachment['file_size'] ?? 0),
            'mime_type' => $attachment['mime_type'] ?? 'application/octet-stream',
            'uploaded_at' => $attachment['uploaded_at'] ?? null,
            'exists_on_disk' => $exists,
            'download_url' => $exists ? Storage::disk('public')->url($filePath) : null,
        ];
    }

    /**
     * Format file size in human readable format.
     *
     * @param int $bytes
     * @return string
     */
    public static function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Get supported file types for display.
     *
     * @return array
     */
    public static function getSupportedFileTypes(): array
    {
        return [
            'images' => ['jpg', 'jpeg', 'png', 'gif'],
            'documents' => ['pdf', 'doc', 'docx', 'txt'],
            'archives' => ['zip'],
        ];
    }

    /**
     * Check if file type is supported.
     *
     * @param string $mimeType
     * @return bool
     */
    public static function isFileTypeSupported(string $mimeType): bool
    {
        return in_array($mimeType, self::ALLOWED_TYPES);
    }

    /**
     * Get file download URL.
     *
     * @param string $filePath
     * @return string
     */
    public function getDownloadUrl(string $filePath): string
    {
        return Storage::disk('public')->url($filePath);
    }

    /**
     * Check if file type is an image.
     *
     * @param string $mimeType
     * @return bool
     */
    public static function isImage(string $mimeType): bool
    {
        return in_array($mimeType, [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/gif',
        ]);
    }
}
