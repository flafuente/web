<?php
// No direct access
defined('_EXE') or die('Restricted access');

/**
 * Menciones Controller
 */
class mencionesController extends Controller
{
    /**
     * Init
     */
    public function init() {}

    /**
     * Default list view
     */
    public function index()
    {
        $config = Registry::getConfig();

        // Pagination
        $pag = array();

        // Total
        $pag['total'] = 0;

        // Limit
        $pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
        $pag['limitStart'] = $_REQUEST['limitStart'];

        // List Select
        $results = Mencion::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']);

        // Setting data to View
        $this->setData("results", $results);
        $this->setData("pag", $pag);

        // Load View to Template var
        $html = $this->view("views.list");

        // Render the Template
        $this->render($html);
    }

    /**
     * Edit form view
     */
    public function edit()
    {
        $url = Registry::getUrl();

        // Load object to view
        $this->setData("mencion", new Mencion($url->vars[0]));
        $this->setData("menciones", Mencion::select());

        // Load View to Template var
        $html = $this->view("views.edit");

        // Render the Template
        $this->render($html);
    }

    /**
     * Save action
     */
    public function save()
    {
        $_REQUEST["form"] = true;

        // Get object
        $mencion = new Mencion($_REQUEST['id']);

        // Editing
        if ($mencion->id) {
            // Update Object
            if ($mencion->update($_REQUEST)) {
                // Add success message
                Registry::addMessage("Mención actualizada satisfactoriamente", "success", "", Url::site("admin/menciones"));
            }
        // Creating
        } else {
            // Insert Object
            if ($mencion->insert($_REQUEST)) {
                // Add success message
                Registry::addMessage("Mención creada satisfactoriamente", "success", "", Url::site("admin/menciones"));
            }
        }

        // Show ajax JSON response
        $this->ajax();
    }

    /**
     * Delete action
     */
    public function delete()
    {
        $url = Registry::getUrl();

        // Get object
        $mencion = new Mencion($url->vars[0]);

        // Object exist?
        if ($mencion->id) {
            // Delete Object
            if ($mencion->delete()) {
                // Add success message
                Registry::addMessage("Mención eliminada satisfactoriamente", "success");
            }
        }

        // Redirect
        Url::redirect(Url::site("admin/menciones"));
    }
}
