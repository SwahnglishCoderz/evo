<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace App\Controllers;

use Evo\View;

class Section extends Authenticated
{
    public function indexAction()
    {
        // retrieve details of all sections from the DB
        View::renderTemplate('Sections/index.html');
    }

    public function newAction()
    {
        // display a form to create a new section
        View::renderTemplate('Sections/create.html');
    }

    public function showAction()
    {
        // retrieve details of a single section from the DB
        View::renderTemplate('Sections/show.html');
    }

    public function addAction()
    {
        // add new section to DB
    }

    public function editAction()
    {
        // display a form to update a section
        View::renderTemplate('Sections/edit.html');
    }

    public function updateAction()
    {
        // updates a section in the DB
    }

    public function deleteAction()
    {
        // deletes a section from the DB
    }

}
