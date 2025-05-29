<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttachmentController;

Route::get('/', function () {
    return redirect('/nova');
});

// Route for removing attachments from customer responses
Route::get('/customer/remove-attachment/{response}/{index}',
    [AttachmentController::class, 'removeAttachment']
)->middleware('auth')->name('attachment.remove');

// Route for customer file downloads (with proper authentication)
Route::get('/customer/download-attachment/{response}/{index}',
    [AttachmentController::class, 'customerDownloadAttachment']
)->middleware('auth')->name('customer.attachment.download');

// Route for admin file downloads (with proper authentication)
Route::get('/admin/download-attachment/{response}/{index}',
    [AttachmentController::class, 'downloadAttachment']
)->middleware('auth')->name('admin.attachment.download');
