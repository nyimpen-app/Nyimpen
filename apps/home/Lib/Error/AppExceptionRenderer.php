<?php
App::uses('ExceptionRenderer', 'Error');

class AppExceptionRenderer extends ExceptionRenderer {

    public function missingController($error) {
        $this->controller->render('/Errors/error404', 'error');
        $this->controller->response->send();
    }

    public function missingAction($error) {
        $this->missingController($error);
    }
	
	 public function notFound($error) {
        $this->missingController($error);
    }
}
?>