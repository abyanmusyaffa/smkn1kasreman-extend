<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DownloadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('downloads')->insert([
            'content' => '<p>Logo SMK N 1 Kasreman</p><p><figure data-trix-attachment="{&quot;contentType&quot;:&quot;image/png&quot;,&quot;filename&quot;:&quot;logo-skanka.png&quot;,&quot;filesize&quot;:1292837,&quot;height&quot;:1280,&quot;href&quot;:&quot;http://smkn1kasreman.test/storage/attachments-download/Yuxuu52Y2f8CSrWO8UwebmkwhpOsqudQKBghc2A6.png&quot;,&quot;url&quot;:&quot;http://smkn1kasreman.test/storage/attachments-download/Yuxuu52Y2f8CSrWO8UwebmkwhpOsqudQKBghc2A6.png&quot;,&quot;width&quot;:1280}" data-trix-content-type="image/png" data-trix-attributes="{&quot;presentation&quot;:&quot;gallery&quot;}" class="attachment attachment--preview attachment--png"><a href="http://smkn1kasreman.test/storage/attachments-download/Yuxuu52Y2f8CSrWO8UwebmkwhpOsqudQKBghc2A6.png"><img src="http://smkn1kasreman.test/storage/attachments-download/Yuxuu52Y2f8CSrWO8UwebmkwhpOsqudQKBghc2A6.png" width="1280" height="1280"><figcaption class="attachment__caption"><span class="attachment__name">logo-skanka.png</span> <span class="attachment__size">1.23 MB</span></figcaption></a></figure><a href="https://drive.google.com/file/d/1TZUU8Sj6mLM3djWb4f_XwY3daf4E42fK/view">Download</a></p>'
        ]);
    }
}
