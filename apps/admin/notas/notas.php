<?php
// No direct access
defined('_EXE') or die('Restricted access');

/**
 * Notas Controller
 */
class notasController extends Controller
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
        $results = Nota::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']);

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
        $this->setData("nota", new Nota($url->vars[0]));

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
        $nota = new Nota($_REQUEST['id']);

        // Editing
        if ($nota->id) {
            // Update Object
            if ($nota->update($_REQUEST)) {
                // Add success message
                Registry::addMessage("Nota actualizada satisfactoriamente", "success", "", Url::site("admin/notas"));
            }
        // Creating
        } else {
            // Insert Object
            if ($nota->insert($_REQUEST)) {
                // Add success message
                Registry::addMessage("Nota creada satisfactoriamente", "success", "", Url::site("admin/notas"));
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
        $nota = new Nota($url->vars[0]);

        // Object exist?
        if ($nota->id) {
            // Delete Object
            if ($nota->delete()) {
                // Add success message
                Registry::addMessage("Nota eliminada satisfactoriamente", "success");
            }
        }

        // Redirect
        Url::redirect(Url::site("admin/notas"));
    }
}
