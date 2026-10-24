<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Xoa du lieu cu de tranh bi trung khi chay lai
        DB::table('comments')->delete();
        DB::table('posts')->delete();
        DB::table('users')->delete();

        // Tao 10 nguoi dung
        $users = User::factory()->count(10)->create();

        // Danh sach 10 bai viet mau
        $baiViet = [
            [
                'title' => 'PHP la gi? Huong dan cho nguoi moi bat dau',
                'content' => 'PHP la ngon ngu lap trinh chay o phia may chu, thuong duoc dung de xay dung website dong.'
            ],
            [
                'title' => 'HTML va CSS trong thiet ke website',
                'content' => 'HTML tao cau truc noi dung trang web, con CSS giup trang web co mau sac va bo cuc dep hon.'
            ],
            [
                'title' => 'Tim hieu co so du lieu MySQL',
                'content' => 'MySQL la he quan tri co so du lieu quan he, giup luu tru va truy van du lieu cua ung dung.'
            ],
            [
                'title' => 'Laravel la gi?',
                'content' => 'Laravel la framework PHP ho tro xay dung ung dung web theo cau truc ro rang va de bao tri.'
            ],
            [
                'title' => 'Cach mot website hoat dong',
                'content' => 'Trinh duyet gui yeu cau den may chu. May chu xu ly yeu cau, truy van du lieu neu can va tra ket qua ve trinh duyet.'
            ],
            [
                'title' => 'Tim hieu ngon ngu lap trinh PHP',
                'content' => 'PHP co the xu ly du lieu bieu mau, ket noi co so du lieu va tao noi dung trang web theo yeu cau.'
            ],
            [
                'title' => 'Ket noi PHP voi MySQL',
                'content' => 'PHP co the su dung cac cong cu nhu PDO hoac MySQLi de ket noi va thao tac voi co so du lieu MySQL.'
            ],
            [
                'title' => 'Tim hieu ve vong lap trong lap trinh',
                'content' => 'Vong lap giup lap lai mot khoi lenh nhieu lan. Cac vong lap pho bien gom for, while va foreach.'
            ],
            [
                'title' => 'Cac buoc xay dung website co ban',
                'content' => 'De xay dung website, can xac dinh yeu cau, thiet ke giao dien, xu ly nghiep vu, tao co so du lieu va kiem thu.'
            ],
            [
                'title' => 'Kinh nghiem hoc lap trinh cho sinh vien IT',
                'content' => 'Sinh vien nen luyen tap thuong xuyen, lam bai tap nho, doc loi bao va tu sua code de hieu ro kien thuc.'
            ],
        ];

        // Tao bai viet va mot binh luan cho moi bai viet
        foreach ($baiViet as $index => $bai) {
            $postId = DB::table('posts')->insertGetId([
                'user_id' => $users[$index]->id,
                'title' => $bai['title'],
                'content' => $bai['content'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('comments')->insert([
                'post_id' => $postId,
                'content' => 'Binh luan mau cho bai viet: ' . $bai['title'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
