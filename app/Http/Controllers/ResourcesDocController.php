<?php

namespace App\Http\Controllers;

use App\ResourcesDoc;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;

class ResourcesDocController extends Controller
{
    //
    public function showResourcesDocManager()
    {
        return view('resource.doc');
    }

    public function getAllResourceDocs(Request $request)
    {
        $data = $request->all();
        // 校验数据
        $validator = Validator::make($data,[
            'page' => 'numeric',
            'rows' => 'numeric',
            'sort' => 'string|max:64',
            'order' => 'in:asc,desc',
            'qname' => 'string|max:24'
        ]);
        if($validator->fails()){
            return $validator->errors();
        }
        if(isset($data['qname'])){
            $rds = ResourcesDoc::orderBy(isset($data['sort'])?$data['sort']:"id",isset($data['order'])?$data['order']:"asc")
                ->where('qiniu_name','like','%'.$data['qname'].'%')->paginate($data['rows']);
            return $rds;
        }
        $rds = ResourcesDoc::orderBy(isset($data['sort'])?$data['sort']:"id",isset($data['order'])?$data['order']:"asc")->paginate($data['rows']);
        return $rds;
    }
    public function create(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();

        // 校验数据
        $validator = Validator::make($data, [
            // 'name' => 'required|max:64',
            'desc' => 'required|max:255',
            'size' => 'required|numeric',
            'private' => 'in:private,public',
            'qiniu_name' => 'required|max:64',
        ]);
        if($validator->fails()){
            return ['success' => false,'msg' => $validator->errors()];
        }
        ResourcesDoc::create([
            // 'name'=>$data['name'],
            'desc'=>$data['desc'],
            // b转换为Kb
            'size'=>$data['size'] / 1024 ,
            'private'=>$data['private'],
            'qiniu_name'=>$data['qiniu_name'],
            'user_id'=>$user->id,
        ]);
        return ['success' => true,'msg' => '新增成功!'];
    }
    public function delete(){
        return ['success' => true,'msg' => '删除成功!'];
    }

    public function update()
    {
        
    }

    public function downloadUrl($id)
    {
        $rc = ResourcesDoc::find($id);
        if($rc->private == 'private'){
            $disk = \Illuminate\Support\Facades\Storage::disk('qiniu-pr');
            return ['success'=> true,'msg'=>'请求成功!','data'=>$disk->getDriver()->privateDownloadUrl($rc->qiniu_name)];
        }else{
            $disk = \Illuminate\Support\Facades\Storage::disk('qiniu-pu');
            return ['success'=> true,'msg'=>'请求成功!','data'=>$disk->getDriver()->downloadUrl($rc->qiniu_name)];

        }
    }
    public function getToken(Request $request)
    {
        $pub = $request->input('pub');
        if($pub == "public"){
            $disk = \Illuminate\Support\Facades\Storage::disk('qiniu-pu');
            return ['uptoken'=>$disk->uploadToken()];
        }else{
            $disk = \Illuminate\Support\Facades\Storage::disk('qiniu-pr');
            return ['uptoken'=>$disk->uploadToken()];
        }
    }
}
