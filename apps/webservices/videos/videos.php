<?php
//No direct access
defined('_EXE') or die('Restricted access');

class videosController extends Controller
{

    /**
     * Init
     */
    public function init()
    {
        //User logged?
        $user = WS::getUser();
        if (!$user->id) {
            WS::setCode(1003);
            WS::output();
        }
    }

    /**
     * Default
     */
    public function index()
    {
        die("Tribo WS: Videos");
    }

    /**
     * User videos list
     */
    public function my()
    {
        //Get user videos
        $user = WS::getUser();
        WS::addData("videos", Video::select(array(
            "userId" => $user->id,
        )));
        WS::output();
    }

    /**
     * Categorías list
     */
    public function categories()
    {
        WS::addData("categorias", Categoria::select());
        WS::output();
    }

    /**
     * Secciones list
     */
    public function secctions()
    {
        WS::addData("secctions", Seccion::select());
        WS::output();
    }

    /**
     * Upload
     * Subida de archivos de vídeo incluida.
     * @todo Hacer el código más limpio.
     */
    public function upload()
    {
        //Config
        $config = Registry::getConfig();
        set_time_limit(0);
        $videoArchivoNull = new VideoArchivo();
        $target = $config->get("path").$videoArchivoNull->path;
        $name = basename($_FILES['file']['name']) ;
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $newname = md5(uniqid()).".".$extension;
        //Size?
        if ($uploaded_size > 350000 && false) {
            //Response
            WS::setCode(2002);
        } else {
            //File type
            if (!preg_match("/\.(mp4|mpg|flv|mpeg|avi)$/i", $name)) {
                //Response
                WS::setCode(2001);
            } else {
                //Move uploaded file
                if (move_uploaded_file($_FILES['file']['tmp_name'], $target.$newname)) {
                    //Video creation
                    $_REQUEST["file"] = $newname;
                    $video = new Video();
                    if (!$video->insert($_REQUEST)) {
                        //Response
                        WS::setCode(1005);
                    }
                }
            }
        }
        WS::output();
    }
}
