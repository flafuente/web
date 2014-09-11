    <?php
//No direct access
defined('_EXE') or die('Restricted access');

class reproductorController extends Controller
{
    public function init() {}

    public function index()
    {
        Url::redirect(Url::site(), "Capítulo incorrecto", "warning");
    }

    public function capitulo()
    {
        $url = Registry::getUrl();
        $capitulo = new Capitulo($url->vars[0]);
        if ($capitulo->id) {

            //Añadimos la visita
            $capitulo->addVisita();

            //Capitulo
            $this->setData("capitulo", $capitulo);

            //Programa
            $this->setData("programa", new Programa($capitulo->programaId));

            //Capítulos
            $this->setData("capitulos", Capitulo::select(array("programaId" => $capitulo->programaId, "estadoId" => 1)));

            //View
            $html = $this->view("views.reproductor");
            $this->render($html);

        } else {
            Url::redirect(Url::site(), "Capítulo incorrecto", "warning");
        }
    }
}
