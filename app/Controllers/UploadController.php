<?php

namespace App\Controllers;

use App\Models\Category;
use App\Utils\BaseTable;
use Core\Auth;
use Core\BaseController;
use Core\Redirect;
use Core\Container;
use App\Services\FileService;

class UploadController extends BaseController
{
    private $file;
    private $fileService;

    public function __construct()
    {
        parent::__construct();
        $this->file = Container::getModel("File");
        $this->fileService = new FileService();
    }

    public function index()
    {
        $this->setPageTitle('Upload');
        $this->view->files = BaseTable::decodeTable($this->file->All(), "upload");
        return $this->renderView('upload/index', 'layout');
    }

    public function show($id)
    {
        $this->view->file = $this->file->find($id);
        $this->setPageTitle("{$this->view->file->title}");
        return $this->renderView('upload/show', 'layout');
    }

    public function create()
    {
        $this->setPageTitle('Upload File');
        return $this->renderView('upload/create', 'layout');
    }

    public function store($request)
    {
        if (!$this->fileService->validateExt($request->file->file)) {
            return Redirect::route('/upload/create', ['errors' => ['Invalid extension file.']]);
        }

        $data = $this->fileService->processXml(
            $this->fileService->loadXml($request->file->file)
        );

        try {
            if (isset($data["error"])) {
                return Redirect::route('/uploads', ['errors' => [$data["error"]]]);
            }

            if ($this->file->create($data['sucess'])) {
                return Redirect::route('/uploads', ['success' => ['Arquivo salvo com sucesso']]);
            }
        } catch (\Exception $e) {
            return Redirect::route('/uploads', ['errors' => [$e->getMessage()]]);
        }
    }

    public function delete($id)
    {
        try {
            if ($this->file->delete($id)) {
                return Redirect::route('/uploads', ['success' => ['NF deletada!']]);
            } else {
                return Redirect::route('/uploads', ['errors' => ['Erro ao excluir!']]);
            }
        } catch (\Exception $e) {
            return Redirect::route('/uploads', ['errors' => [$e->getMessage()]]);
        }
    }
}
