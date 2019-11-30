<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Get all the files of the app
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFiles()
    {
        $files = File::all();

        return response()->json($files);
    }

    public function getOneFile($id)
    {
        try {
            return response()->json(File::findOrFail($id));
        }
        catch (\Exception $ex) {
            if(config('app.debug'))
                return response()->json([
                    'error' => 'The folder does not exist or the id is not a good one',
                    'message' => $ex->getMessage(),
                    'trace' => $ex->getTraceAsString(),
                ], 500);
            return response()->json([
                'error' => 'The folder does not exist or the id is not a good one'
            ], 500);
        }
    }

    /**
     * Upload and Save a file
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFile(Request $request)
    {
        try {
            $category = $request->category;
            $uv = $request->uv;
            $file = $request->file;

            $res = File::where('name', $file->getClientOriginalName())->first();
            if(!is_null($res)) return response()->json([
                'error' => 'The file already exist'
            ], 500);

            // Save the incoming file
            $path = $file->store('IN4', 'public');

            // Create and Save a new File object
            $file = File::create([
                'name' => $file->getClientOriginalName(),
                'type' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
                'url' => 'storage/' . $path,
                'folder_id' => $category,
                'user_id' => null,
            ]);
            return response()->json($file);
        }
        catch (\Exception $ex)
        {
            if(config('app.debug'))
                return response()->json([
                    'error' => 'The file does not exist or the id is not a good one',
                    'message' => $ex->getMessage(),
                    'trace' => $ex->getTraceAsString(),
                ], 500);
            return response()->json([
                'error' => 'The folder does not exist or the id is not a good one'
            ], 500);
        }
    }

    /**
     * Get the file
     *
     * @param $id
     * @param bool $shouldDownload
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getFile($id, $shouldDownload = true)
    {
        try {
            $file = File::findOrFail($id);

            return $shouldDownload == 'true'
                ? response()->download(public_path($file->url))
                : response()->file(public_path($file->url));
        }
        catch (\Exception $ex)
        {
            if(config('app.debug'))
                return response()->json([
                    'error' => 'The file does not exist or the id is not a good one',
                    'message' => $ex->getMessage(),
                    'trace' => $ex->getTraceAsString(),
                ], 500);
            return response()->json([
                'error' => 'The file does not exist or the id is not a good one'
            ], 500);
        }
    }

    /**
     * Get a the file itself
     *
     * @param $id
     */
    public function fd($id)
    {
        $file = File::findOrFail($id);

        dd('dqqsdqs');

        return response()->file(Storage::get($file->url));
        /*
        try {
            $file = File::findOrFail($id);

            return response()->file(Storage::get($file->url));
        }
        catch (\Exception $ex)
        {
            if(config('app.debug'))
                return response()->json([
                    'error' => 'The folder does not exist or the id is not a good one',
                    'message' => $ex->getMessage(),
                    'trace' => $ex->getTraceAsString(),
                ], 500);
            return response()->json([
                'error' => 'The folder does not exist or the id is not a good one'
            ], 500);
        }*/
    }
}
