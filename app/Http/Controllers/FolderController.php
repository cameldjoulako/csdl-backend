<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    /**
     * Get all the folders of the app
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFolders()
    {
        $folders = Folder::all();

        return response()->json($folders);
    }

    /**
     * Get the sub folders of a folder
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubFoldersOfOneFolder($id)
    {
        try {
            // $folder = Folder::findOrFail($id);
            $folder = Folder::where('id', $id)->with('subFolders', 'parent')->first();

             return response()->json($folder->subFolders);
        }
        catch (\Exception $ex)
        {
            if(config('app.debug'))
                return response()->json([
                    'error' => 'The folder does not exist or the id is not a good one',
                    'message' => $ex->getMessage(),
                    'trace' => $ex->getTraceAsString(),
                ]);
            return response()->json([
                'error' => 'The folder does not exist or the id is not a good one'
            ]);
        }
    }

    public function getFileOfOneFolder($id)
    {
        try  {
            $folder = Folder::where('id', $id)->with('files')->first();

            return response()->json($folder->files);
        }
        catch (\Exception $ex) {
            if(config('app.debug'))
                return response()->json([
                    'error' => 'The folder does not exist or the id is not a good one',
                    'message' => $ex->getMessage(),
                    'trace' => $ex->getTraceAsString(),
                ]);
            return response()->json([
                'error' => 'The folder does not exist or the id is not a good one'
            ]);
        }
    }

    public function getOneFolder($id)
    {
        try {
            return response()->json(Folder::findOrFail($id));
        }
        catch (\Exception $ex) {
            if(config('app.debug'))
                return response()->json([
                    'error' => 'The folder does not exist or the id is not a good one',
                    'message' => $ex->getMessage(),
                    'trace' => $ex->getTraceAsString(),
                ]);
            return response()->json([
                'error' => 'The folder does not exist or the id is not a good one'
            ]);
        }
    }

    /**
     * Upload and Save a file
     *
     * @param Request $request
     */
    public function uploadFile(Request $request)
    {
        try {
            $category = $request->category;
            $uv = $request->uv;
            $file = $request->file;

            // Save the incoming file
            $path = $file->store('IN4');

            // Create and Save a new File object
            $file = File::create([
                'name' => $file->getClientOriginalName(),
                'type' => $file->getClientOriginalExtension(),
                'size' => $file->getSize,
                'url' => $path,
                'folder_id' => $category,
                'user_id' => null,
            ]);
            return response()->json($file);
        }
        catch (\Exception $ex)
        {
            if(config('app.debug'))
                return response()->json([
                    'error' => 'The folder does not exist or the id is not a good one',
                    'message' => $ex->getMessage(),
                    'trace' => $ex->getTraceAsString(),
                ]);
            return response()->json([
                'error' => 'The folder does not exist or the id is not a good one'
            ]);
        }
    }
}
