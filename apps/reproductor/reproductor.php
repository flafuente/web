    <?php
//No direct access
defined('_EXE') or die('Restricted access');

class reproductorController extends Controller
{
    public function init() {}

    public function index()
    {
        Url::redirect(Url::site(), Language::translate("CTRL_REPRODUCTOR_CAPITULO_NOTFOUND"), "warning");
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

            //View
            $html = $this->view("views.reproductor");
            $this->render($html);

        } else {
            Url::redirect(Url::site(), Language::translate("CTRL_REPRODUCTOR_CAPITULO_NOTFOUND"), "warning");
        }
    }

    public function like()
    {
        $url = Registry::getUrl();

        $capitulo = new Capitulo($url->vars[0]);
        if ($capitulo->id) {
            $capitulo->like();
        }
        $this->ajax(array("total" => $capitulo->likes));
    }

    public function unlike()
    {
        $url = Registry::getUrl();

        $capitulo = new Capitulo($url->vars[0]);
        if ($capitulo->id) {
            $capitulo->unlike();
        }
        $this->ajax(array("total" => $capitulo->likes));
    }
}
