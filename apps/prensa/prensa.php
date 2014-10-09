<?php
//No direct access
defined('_EXE') or die('Restricted access');

class prensaController extends Controller
{
    public function init() {

    }

    public function index() {
        $html = $this->view("views.prensa");
        $this->render($html);
    }

    public function nota(){
        $notaEjemplo = new stdClass();
        $notaEjemplo->imagen = Url::template("img/cosmotrip.png");
        $notaEjemplo->titulo = "TRIBO TV YA SE PUEDE VER EN TODAS LAS COMUNIDADES AUTÓNOMAS";
        $notaEjemplo->descripcion = "Este octubre comienza una nueva historia, la aventura de las mil y una caras, las caras de Tribo, la televisión de todos hecha ";
        $notaEjemplo->nota = "Desde las Personas para las Personas, desde el mundo diario para el mundo diario, desde la universalidad de conceptos, contenidos, ideas, una “factoría de sueños” hecha realidad: NACE TRIBO TV, la televisión que  revolucionará España.
Como todo sueño TRIBO TV tiene un origen, un Dreamshaker que quiso hacer realidad lo que echaba de menos: una plataforma de colectividad e individualidad en colectivo, un sitio donde elegir y ser elegido, donde poder comunicar al mundo lo que la gente sueña, lo que necesitamos, lo que mueve nuestras vidas, cada instante que pasa desapercibido a los ojos de la mayoría de las televisiones habituales.
TRIBO TV es el resultado de ese Dreamshaker y su socio que, junto a él, han sido capaces de que hoy podamos presentar la nueva televisión del futuro; una fábrica de ideas, de aspiraciones, de reflejo de la sociedad de hoy y su evolución y de cada TRIBER que la hace posible;
BE TRIBER, BE TRIBO TV, haz nuestra televisión y se parte de nosotros y  participa de un proyecto de miles de voces que hoy encuentran una plataforma ON TIME para expresarse y hacer que TODOS podamos divertirnos, pensar, emocionarnos, vestirnos, disfrutar de la gastronomía a nuestra manera o simplemente comunicar lo que vemos por la calle y nunca se pudo compartir en directo  en un soporte tan habitual como la televisión, esa “pequeña pantalla” que hoy tendrá visos de ser muy grande.
Luis Sans, nuestro Dreamshaker de esta nueva aventura y su socio Jose Mª Garrido (CEO de TRIBO) junto con un equipo fundador que ha creído en su sueño y que está compuesto por profesionales de la empresa española como Oscar Márquez (Director General de TRIBO TV) y ejecutivos históricos de la televisión habitual como Javier Gimeno, o del derecho como Javier Vicente (Director Jurídico y de RRHH) conforman el equipo que han hecho posible que TRIBO TV sea hoy una realidad. Un proyecto que el 1 de OCTUBRE veremos por fin ya en TODA la Comunidad de Madrid y a partir de este mes en todo el resto de España: Andalucía, Valencia, Alicante, Galicia, Cataluña.
Una parrilla compuesta por diversión a raudales desde la calle, deportes como nunca los habías visto,  cultura en webseries que hacen historia en las redes , noticias a la manera de la gente que quiere contarlas y en su ángulo, moda desde la moda real o las recetas y la gastronomía que siempre quisiste saber y nunca te contaron como…
TRIBO TV es ya todo eso y MUCHO MÁS, y será lo que TÚ quieras que SEA.";
        $notaEjemplo->adjunto = "URL_Al_archivo.pdf";
        $notaEjemplo->fecha = date("d / m / Y");
        $this->setData("nota", $notaEjemplo);

        $html = $this->view("views.nota");
        $this->render($html);

    }
}
