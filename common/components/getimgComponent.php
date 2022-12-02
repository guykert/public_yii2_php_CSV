<?php 

    namespace common\components;


    use Yii;
    use yii\base\Component;
    use yii\helpers\Json;
    use common\models\Curso;

    class getimgComponent extends Component {


        public function readImage($filename="descarga.jpg")
        {

 

            // $path=Yii::getPathOfAlias('webroot.protected.upload.images') . '/';

            $path = utf8_decode(Yii::getAlias('@backend')."/uploads/1/profile/");

            $file=$path.$filename;

            // echo "test3 : " . $file;

            // echo "test3 : " . (file_exists($file));
            // exit;

            if (file_exists($file))

            {

                // header('Content-Type: image/jpeg');

                // header('Content-Length: ' . filesize($file));
                
                // $img = Yii::app()->imagemod->load($file);

                // $img->file_new_name_body = md5($img->file_src_name);

                // header('Content-type: ' . $img->file_src_mime);


                // echo $img->process();

                // $path = utf8_decode("C:\\wamp64\\www\\desarrollo_csv\\backend\\uploads\\1\\profile\\descarga.jpg");

                $size = getimagesize($file);

                $fp = fopen($file, 'rb');
            
                // echo "test3 : " . $file;

                // echo "test4 : " . $size;



                
                // echo "test4 : " . ($size and $fp);
                // exit;

                if ($size and $fp)
                {
                    // Optional never cache
                //  header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
                //  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                //  header('Pragma: no-cache');
            
                    // Optional cache if not changed
                //  header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($file)).' GMT');
            
                    // Optional send not modified
                //  if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) and 
                //      filemtime($file) == strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']))
                //  {
                //      header('HTTP/1.1 304 Not Modified');
                //  }
            
                    header('Content-Type: '.$size['mime']);
                    header('Content-Length: '.filesize($path));
            
                    fpassthru($fp);
            
                    exit;
                }


                // return Yii::$app->response->sendFile($file);

             }

            else

            {

                 return "";

            }



        }


    }

?>

