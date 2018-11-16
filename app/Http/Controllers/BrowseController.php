<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use User;

class BrowseController extends Controller
{
    public function show($object)
    {
        //$browseResults = DB::table($object)->get();
        switch ($object) {
            case 'client':
                $browseResults = DB::table('users')
                    ->select('id', 'name', 'sex', 'phone')
                    ->where('cno', '<>', 'null')
                    ->simplePaginate(25);
                $ths = array('编号', '名字', '性别', '电话');
                break;
            case 'agency':
                $browseResults = DB::table('users')
                    ->select('id', 'name', 'sex', 'phone')
                    ->where('ano', '<>', 'null')
                    ->simplePaginate(25);
                $ths = array('编号', '名字', '性别', '电话');
                break;
            case 'medicine':
                $browseResults = DB::table('medicines')
                    ->select('mno', 'mname', 'mmode', 'mnum', 'mouttime')
                    ->orderBy('mouttime', 'asc')
                    ->simplePaginate(15);
                $ths = array('编号', '药名', '用法', '剩余数量', '有效期至');
                break;
        }
        return view('browse', ['browseResults' => $browseResults, 'ths' => $ths,'item'=>$object]);
    }
}
