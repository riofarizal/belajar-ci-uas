<?php

namespace App\Controllers;

use App\Models\DiskonModel;

class DiskonController extends BaseController
{
    protected $diskonModel;

    public function __construct()
    {
        $this->diskonModel = new DiskonModel();
        
        // Check if user is admin
        //if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            //throw new \CodeIgniter\Exceptions\PageNotFoundException('Access denied');
        //}
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Diskon',
            'diskons' => $this->diskonModel->orderBy('tanggal', 'DESC')->findAll()
        ];
        
        return view('v_diskon', $data);
    }

    public function store()
    {
        if (!$this->validate($this->diskonModel->getValidationRules())) {
            return redirect()->to('/diskon')->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal')
        ];

        if ($this->diskonModel->insert($data)) {
            return redirect()->to('/diskon')->with('success', 'Diskon berhasil ditambahkan!');
        } else {
            return redirect()->to('/diskon')->withInput()->with('error', 'Gagal menambahkan diskon!');
        }
    }

    public function update($id)
    {
        $diskon = $this->diskonModel->find($id);
        
        if (!$diskon) {
            return redirect()->to('/diskon')->with('error', 'Diskon tidak ditemukan!');
        }

        // Custom validation for update (exclude current record from unique check)
        $rules = [
            'nominal' => 'required|numeric|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/diskon')->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nominal' => $this->request->getPost('nominal')
            // tanggal is readonly in edit form
        ];

        if ($this->diskonModel->update($id, $data)) {
            return redirect()->to('/diskon')->with('success', 'Diskon berhasil diupdate!');
        } else {
            return redirect()->to('/diskon')->withInput()->with('error', 'Gagal mengupdate diskon!');
        }
    }

    public function delete($id)
    {
        $diskon = $this->diskonModel->find($id);
        
        if (!$diskon) {
            return redirect()->to('/diskon')->with('error', 'Diskon tidak ditemukan!');
        }

        if ($this->diskonModel->delete($id)) {
            return redirect()->to('/diskon')->with('success', 'Diskon berhasil dihapus!');
        } else {
            return redirect()->to('/diskon')->with('error', 'Gagal menghapus diskon!');
        }
    }
}