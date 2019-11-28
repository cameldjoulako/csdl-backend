<?php

use \App\Models\Folder;
use Illuminate\Database\Seeder;

class FolderTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            'Complexités et Algorithmes Avancées',
            'Génie Logiciel II',
            'Cloud Computing',
            'Réseaux',
            'Systèmes Cryptographiques'
        ];

        $subFolder = [
            'Cours',
            'TD',
            'Fax',
            'Exposés',
            'Autres'
        ];

        $root = Folder::create([
            'name' => 'IN4',
            'parent_id' => null
        ]);

        $sem1 = Folder::create([
            'name' => 'Semestre 1',
            'parent_id' => $root->id
        ]);

        $sem2 = Folder::create([
            'name' => 'Semestre 2',
            'parent_id' => $root->id
        ]);

        foreach ($list as $item)
        {
            $folder = Folder::create([
                'name' => $item,
                'parent_id' => $sem1->id
            ]);
            foreach ($subFolder as $subItem)
            {
                Folder::create([
                    'name' => $subItem,
                    'parent_id' => $folder->id
                ]);
            }
        }
    }
}
