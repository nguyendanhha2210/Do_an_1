<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use File;
use Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Flysystem\AwsS3v3\AwsS3Adapter;

class DocumentController extends Controller
{
    public function upload_file()
    {
        $filename = 'Anthony Robbins.pdf';
        $filePath = public_path('uploads\document\File PDF Test.pdf');
        $fileData = File::get($filePath);
        Storage::cloud()->put($filename, $fileData);
        return 'File PDF Uploaded';
    }

    public function create_document()
    {
        Storage::disk('s3')->put('test.txt', 'Storage 1');
        dd('created');
    }

    public function upload_image()
    {
        $filename = '4.jpg';
        $filePath = public_path('uploads\products\4.jpg');
        $fileData = File::get($filePath);
        Storage::cloud()->put($filename, $fileData);
        return 'Image Uploaded';
    }

    public function upload_video()
    {
        $filename = 'video_hd720.mp4';
        $filePath = public_path('frontend/images/samplevideo.mp4');
        $fileData = File::get($filePath);
        Storage::cloud()->put($filename, $fileData);
        return 'Video Uploaded';
    }

    public function download_document($path, $name)
    {
        $contents = collect(Storage::cloud()->listContents('/', false))
            ->where('type', '=', 'file')
            ->where('path', '=', $path)
            ->first();
        $filename_download = $name;
        $rawData = Storage::cloud()->get($path);
        return response($rawData, 200)
            ->header('Content-Type', $contents['mimetype'])
            ->header('Content-Disposition', " attachment; filename=$filename_download ");
        return redirect()->back();
    }

    public function create_folder()
    {
        Storage::cloud()->makeDirectory('Storage 2');
        dd('created folder');
    }

    public function rename_folder()
    {
        $folderinfo = collect(Storage::cloud()->listContents('/', false))
            ->where('type', 'dir')
            ->where('name', 'document')
            ->first();
        Storage::cloud()->move($folderinfo['path'], 'Storage');
        dd('renamed folder');
    }

    public function delete_folder()
    {
        $folderinfo = collect(Storage::cloud()->listContents('/', false))
            ->where('type', 'dir')
            ->where('name', 'Storage')
            ->first();
        Storage::cloud()->delete($folderinfo['path']);
        dd('deleted folder');
    }

    public function list_document()
    {
        $dir = '/';
        $recursive = true; // Có lấy file trong các thư mục con không?
        $contents = collect(Storage::cloud()->listContents($dir, $recursive))->where('type', '!=', 'dir');
        return $contents;
    }

    public function delete_document($path)
    {
        $fileinfo = collect(Storage::cloud()->listContents('/', false))
            ->where('type', 'file')
            ->where('path', $path)
            ->first();
        Storage::cloud()->delete($fileinfo['path']);
        return redirect()->back();
    }

    public function readData()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Google Drive'];
            $dir = '/';
            $recursive = false; // Có lấy file trong các thư mục con không?
            $contents = collect(Storage::cloud()->listContents($dir, $recursive))
                ->where('type', '!=', 'dir');
            return view('admin.googledrive.read', ['breadcrumbs' => $breadcrumbs])->with(compact('contents'));
        }
    }
}
