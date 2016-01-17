<?php

namespace Anax\Tags;

/**
 * A controller for users and admin related events.
 *
 */
class TagsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

     private $pagekey;

		/**
	 * Initialize the controller.
	 *
	 * @return void
	 */
	public function initialize()
	{
		$this->comments = new \Anax\Tags\Tag();
		$this->comments->setDI($this->di);
	}


    public function tagAction($id = null) {

        if(isset($id))
        {
            $this->listAction($id);
        } else {
            $this->listAllAction();
        }

    }

	public function listAllAction($orderby = null) {

		$this->user = new \Anax\Users\User();
		$this->user->setDI($this->di);

    if(isset($orderby)) {
		$all = $this->comments->query()
        ->orderby($orderby . ' DESC')
        ->execute();

        $this->theme->setTitle('Questions orderby ' . $orderby);
    } else {
        $all = $this->comments->query()
        ->orderby('created DESC')
        ->execute();
    }

        $this->views->add('tag/list-all', [
            'comments' => $all,
			'user' => $this->user,
            'orderby' => $orderby,
            'title' => "Alla Taggar",
        ]);

		// Formulär
		//$this->addAction();


	}

    public function getLatestTagsAction()
    {
        $all = $this->comments->query()
        ->orderby('rate DESC LIMIT 5')
        ->execute();

        $this->views->add('tag/widget', [
            'latest_tags' => $all,
            'title' => "Populäraste taggarna",
        ]);
    }


    public function listAction($id) {

		$this->user = new \Anax\Users\User();
		$this->user->setDI($this->di);

		// Kommentarer
        $q = $this->comments->find($id);
		$all = $this->comments->query()
        ->where('id = ?')
        ->execute([$id]);

        $this->theme->setTitle($q->getProperties()['heading']);

        $this->views->add('tag/list-all', [
            'comments' => $all,
			'user' => $this->user,
            'title' => "Kommentarer",
        ]);
	}

    public function updateAction($id = null)
    {
        $this->theme->setTitle('Uppdatera en tag');

        if (!isset($id)) {
            die("Missing id");
        }

        if(!$this->session->has('user_loggedin') || $this->session->get('user_loggedin')['rank'] < 99)
        {
            die("You can't edit this tag");
        }

        $tag = $this->comments->find($id);
        $desc = $tag->getProperties()['description'];
        $name = $tag->getProperties()['name'];

        $form = new \Anax\HTMLForm\FormUpdateTag($id, $desc, $name);
        $form->setDI($this->di);
        $status = $form->check();

        $this->di->views->add('users/form', [
            'title' => "Uppdatera en tag",
            'content' => $form->getHTML(),
            ]);

        if($status === true) {
            echo 'true';
            $url = $this->url->create('list');
            $form->response->redirect($url);
        }
    }


    public function resetDatabaseAction() {
        $this->db->setVerbose();

        $this->db->dropTableIfExists('tag')->execute();

        $this->db->createTable(
            'tag',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'name'       => ['varchar(80)'],
                'description'   => ['text'],
                'rate'          => ['integer'],
                'created'       => ['datetime'],
            ]
        )->execute();
    }

    public function createDatabaseAction()
    {
        $this->db->setVerbose();

        $this->db->dropTableIfExists('tag')->execute();

        $this->db->createTable(
            'tag',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'name'       => ['varchar(80)'],
                'description'   => ['text'],
                'rate'          => ['integer'],
                'created'       => ['datetime'],
            ]
        )->execute();

        $this->db->insert(
        'tag',
        ['name', 'description', 'rate', 'created']
        );

        $now = gmdate('Y-m-d H:i:s');



        $this->db->execute([
            'PHP',
            'PHP - Ett programmeringsspråk för webben. PHP - Ett programmeringsspråk för webben. PHP - Ett programmeringsspråk för webben. PHP - Ett programmeringsspråk för webben.',
            '5',
            $now
        ]);

        $this->db->execute([
            'C++',
            'C++ - Ett programmeringsspråk för program.',
            '2',
            $now
        ]);
        $this->db->execute([
            'java',
            'C++ - Ett programmeringsspråk för program.',
            '0',
            $now
        ]);
        $this->db->execute([
            'Datorkomponenter',
            'C++ - Ett programmeringsspråk för program.',
            '10',
            $now
        ]);
        $this->db->execute([
            'CSS',
            'C++ - Ett programmeringsspråk för program.',
            '5',
            $now
        ]);
        $this->db->execute([
            'HTML',
            'C++ - Ett programmeringsspråk för program.',
            '2',
            $now
        ]);
        $this->db->execute([
            'HTML5',
            'C++ - Ett programmeringsspråk för program.',
            '2',
            $now
        ]);
    }
}
