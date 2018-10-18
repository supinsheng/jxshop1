<?php

namespace controllers;

class CodeController {

    public function make(){

        // 接收参数（生成代码的表名）
        $tableName = $_GET['name'];

        // 取出这个表中所有的字段信息
        $sql = "SHOW FULL FIELDS FROM $tableName";
        $db = \libs\Db::make();
        // 预处理
        $stmt = $db->prepare($sql);
        // 执行sql
        $stmt->execute();
        // 取出数据
        $fields = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // 收集所有字段的白名单
        $fillable = [];
        foreach($fields as $v){
            if($v['Field'] == 'id' || $v['Field'] == 'created_at') continue;
            $fillable[] = $v['Field'];
        }
        $fillable = implode('","', $fillable);
        
        // 生成控制器
        $cname = ucfirst($tableName).'Controller';
        $mname = ucfirst($tableName);

        // 加载模板
        ob_start();
        include(ROOT . 'templates/controller.php');

        $str = ob_get_clean();
        
        file_put_contents(ROOT.'controllers/'.$cname.'.php',"<?php\r\n".$str);

        // 生成模型
        ob_start();
        include(ROOT.'templates/model.php');
        $str = ob_get_clean();

        file_put_contents(ROOT.'models/'.$mname.'.php',"<?php\r\n".$str);

        // 生成视图文件
        @mkdir(ROOT.'views/'.$tableName,0777);

        // create.html
        ob_start();
        include(ROOT.'templates/create.html');

        $str = ob_get_clean();
        file_put_contents(ROOT.'views/'.$tableName.'/create.html',$str);

        // edit.html
        ob_start();
        include(ROOT.'templates/edit.html');

        $str = ob_get_clean();
        file_put_contents(ROOT.'views/'.$tableName.'/edit.html',$str);

        // index.html
        ob_start();
        include(ROOT.'templates/index.html');

        $str = ob_get_clean();
        file_put_contents(ROOT.'views/'.$tableName.'/index.html',$str);
    }
}