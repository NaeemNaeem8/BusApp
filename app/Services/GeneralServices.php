<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Symfony\Component\Uid\Ulid;

class GeneralServices
{
    public static function change_file($oldFile, $folder, $newFile)
    {
        $path = 'storage/' . $oldFile;
        if (File::exists($path)) {
                unlink($path);
        }
        return $newFile->store($folder, 'public');
    }
    public static function ulid(string $table): string
    {
        $ids = DB::table($table)->pluck('id');
        do {
            $ulid = Ulid::generate();
        } while ($ids->contains($ulid));
        return $ulid;
    }

    public static function delete_image($file)
    {
        $path = 'storage/' . $file;
        if (File::exists($path)) {
            unlink($path);
        }
    }

    public static function check_duplicates(array $array): bool
    {
        return count($array) !== count(array_unique($array));
    }

    public static function convert_to_array(array $array,string $key) : array
    {
       return array_map(fn($v) => $v[$key] ,$array);
    }
}
