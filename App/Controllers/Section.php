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
    public function index()
    {
        // retrieve details of all sections from the DB
        View::renderTemplate('section/index.html');
    }

    public function new()
    {
        // display a form to create a new section
        View::renderTemplate('section/create.html');
    }

    public function show()
    {
        // retrieve details of a single section from the DB
        View::renderTemplate('section/show.html');
    }

    public function add()
    {
        // add new section to DB
    }

    public function edit()
    {
        // display a form to update a section
        View::renderTemplate('section/edit.html');
    }

    public function update()
    {
        // updates a section in the DB
    }

    public function delete()
    {
        // deletes a section from the DB
    }
}
