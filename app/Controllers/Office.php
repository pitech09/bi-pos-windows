<?php

namespace App\Controllers;

use App\Models\Employee;
use CodeIgniter\HTTP\ResponseInterface;

class Office extends Secure_Controller
{
    protected Employee $employee;

    public function __construct()
    {
        parent::__construct('office', null, 'office');
        
        // FORCE the session menu group to 'office' so the parent loads the right data
        $this->session->set('menu_group', 'office');
    }

    public function getIndex(): string
    {
        // Fetch the modules directly and pass them explicitly
        $module_model = model('Module');
        $employee_info = $this->employee->get_logged_in_employee_info();
        
        $data['allowed_modules'] = $module_model->get_allowed_office_modules($employee_info->person_id)->getResult();
        
        // Pass $data explicitly to the view. This overrides anything the parent did.
        return view('home/office', $data);
    }

    public function logout(): void
    {
        $this->employee = model(Employee::class);
        $this->employee->logout();
    }
}