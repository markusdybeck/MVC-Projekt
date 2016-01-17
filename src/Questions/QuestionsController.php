<?php

namespace Anax\Questions;

/**
 * A controller for users and admin related events.
 *
 */
class QuestionsController implements \Anax\DI\IInjectionAware
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
		$this->comments = new \Anax\Questions\Question();
		$this->comments->setDI($this->di);
    }


    public function questionAction($id = null, $orderby = null) {
        if(isset($id))
        {
            $this->listAction($id, $orderby);
        } else {
            $this->listAllAction();
        }

    }

	public function listAllAction($orderby = null, $tag = null) {

        $this->user = new \Anax\Users\User();
		$this->user->setDI($this->di);

        // List all questions
        if(isset($orderby) && isset($tag)) {
            if(isset($orderby)) {
        		$all = $this->comments->query()
                ->where("tags like '%" . $tag . "%'" )
                ->orderby($orderby . ' DESC')
                ->execute();

                $this->theme->setTitle('Questions orderby ' . $orderby);
            } else {
                $all = $this->comments->query()
                ->where("tags like '%" . $tag . "%'" )
                ->orderby('created DESC')
                ->execute();
            }
        } else {
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
        }

        $this->views->add('question/list-all', [
            'comments' => $all,
			'user' => $this->user,
            'orderby' => $orderby,
            'title' => "Alla Frågor",
            'tag' => $tag,
        ]);


	}

    public function getLatestQuestionsAction()
    {
        $this->user = new \Anax\Users\User();
		$this->user->setDI($this->di);

        $all = $this->comments->query()
        ->orderby('created DESC LIMIT 5')
        ->execute();

        $this->views->add('question/widget', [
            'latest_questions' => $all,
			'user' => $this->user,
            'comment' => $this->comments,
            'title' => "Senaste Frågorna",
        ]);
    }

    public function userAction($id) {
        $this->user = new \Anax\Users\User();
		$this->user->setDI($this->di);

		// Kommentarer
		$all = $this->comments->query()
        ->where('user_id = ?')
        ->execute([$id]);

        $this->theme->setTitle('Frågor');

        $this->views->add('question/simpellist', [
            'comments' => $all,
			'user' => $this->user,
            'title' => 'Frågor',
        ]);

    }

    public function plusoneAction($id, $qid) {
        $question = $this->comments->find($qid);
        $rank = $question->getProperties()['rate'] + 1;
        //var_dump($rank);
        $save = $this->comments->save(array('id' => $qid, 'rate' => $rank));
        if($save) {
            $this->user = new \Anax\Users\User();
    		$this->user->setDI($this->di);
            $this->user->plusminus($id);
        }
        $url =  $this->url->create('questions/question/' . $qid);
        $this->response->redirect($url);
    }

    public function minusoneAction($id, $qid) {
        $question = $this->comments->find($qid);
        $rank = $question->getProperties()['rate'] - 1;
        //var_dump($rank);
        $save = $this->comments->save(array('id' => $qid, 'rate' => $rank));
        if($save) {
            $this->user = new \Anax\Users\User();
    		$this->user->setDI($this->di);
            $this->user->plusminus($id, true);
        }
        $url =  $this->url->create('questions/question/' . $qid);
        $this->response->redirect($url);
    }


    public function listAction($id, $orderby = null) {

		$this->user = new \Anax\Users\User();
		$this->user->setDI($this->di);

		// Kommentarer
        $q = $this->comments->find($id);
		$all = $this->comments->query()
        ->where('id = ?')
        ->execute([$id]);

        $this->theme->setTitle($q->getProperties()['heading']);

        $this->views->add('question/list', [
            'comments' => $all,
			'user' => $this->user,
            'title' => $q->getProperties()['heading'],
        ]);

            $this->dispatcher->forward([
                'controller' => 'comments',
                'action'     => 'get-Comment-System',
                'params'    => [
                    'key' => $id,
                    'orderby' => $orderby],
            ]);

        // // Formulär
		// $this->addAction();

	}

    public function askAction()
	{
        $this->user = new \Anax\Users\User();
		$this->user->setDI($this->di);


        $this->theme->setTitle('Ställ en fråga');


        if($this->session->has("user_loggedin"))
        {
            // SvarsFormulär
        	$form = new \Anax\HTMLForm\FormAddQuestion();
            $form->setDI($this->di);
            $status = $form->check();
            $this->di->views->add('users/form', [
            'title' => "Din fråga",
            'content' => $form->getHTML(),
            ]);

            if($status === true) {
            $url = $this->url->create('list');
            $form->response->redirect($url);
        }
        } else {
            // LoginFormulär
            $this->dispatcher->forward([
                'controller' => 'logins',
                'action'     => 'easy-Login',
                'params'    => ['title' => 'Logga in för att ställa en fråga.'],
            ]);
        }

	}

    public function updateAction($id = null)
    {

        $this->theme->setTitle('Uppdatera en fråga');

        if (!isset($id)) {
            die("Missing id");
        }

        $tag = $this->comments->find($id);
        if(!$this->session->has('user_loggedin') || ($this->session->get('user_loggedin')['id'] !=  $tag->getProperties()['user_id']))
        {
            die("You can't edit this question");
        }

        $desc = $tag->getProperties()['description'];
        $heading = $tag->getProperties()['heading'];
        $tags = $tag->getProperties()['tags'];

        $form = new \Anax\HTMLForm\FormUpdateQuestion($id, $heading, $desc, $tags);
        $form->setDI($this->di);
        $status = $form->check();

        $this->di->views->add('users/form', [
            'title' => "Uppdatera " . $heading,
            'content' => $form->getHTML(),
            ]);

        if($status === true) {
            echo 'true';
            $url = $this->url->create('list');
            $form->response->redirect($url);
        }
    }



    private function slugify($str) {
	  $str = mb_strtolower(trim($str),'UTF-8');
	  $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
	  $str = preg_replace('/[^a-z0-9-]/', '-', $str);
	  $str = trim(preg_replace('/-+/', '-', $str), '-');
	  return $str;
	}

    public function resetDatabaseAction() {
        $this->db->setVerbose();

        $this->db->dropTableIfExists('question')->execute();

        $this->db->createTable(
            'question',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'user_id'       => ['integer', 'not null'],
                'heading'       => ['varchar(80)'],
                'tags'          => ['char(50)'],
                'description'   => ['text'],
                'rate'          => ['integer'],
                'category'      => ['varchar(80)'],
                'created'       => ['datetime'],
                'updated'       => ['datetime'],
                'deleted'       => ['datetime'],
            ]
        )->execute();

    }

    public function createDatabaseAction()
    {
        $this->db->setVerbose();

        $this->db->dropTableIfExists('question')->execute();

        $this->db->createTable(
            'question',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'user_id'       => ['integer', 'not null'],
                'heading'       => ['varchar(80)'],
                'tags'          => ['char(50)'],
                'description'   => ['text'],
                'rate'          => ['integer'],
                'category'      => ['varchar(80)'],
                'created'       => ['datetime'],
                'updated'       => ['datetime'],
                'deleted'       => ['datetime'],
            ]
        )->execute();

        $this->db->insert(
        'question',
        ['user_id', 'heading', 'tags', 'description', 'rate', 'created']
        );

        $now = gmdate('Y-m-d H:i:s');
        $heading = 'Test Fråga';


        $this->db->execute([
            '1',
            $heading,
            'PHP,C++,Datorkomponenter,Grafikkort',
            'Hej, detta är en fråga',
            '2',
            $now
        ]);

        $this->db->execute([
            '1',
            'Dator startar inte!',
            'PHP,C++,HoN,CSGO,Grafikkort',
            '!Hej!
            Jag har precis köpt en nya processor och moderkort. Efter jag hade satt in både moderkortet och processorn i datorn, så vägrar den starta.
            Har trippelkollat så allt sitter rätt, men hittar inget fel. Har köpt en Asus B85M-G motherboard och en i5 4690k proccessor. Övriga specs: GX Bronze 650W, geforce gtx 960 msi.
            Jag har provat att sätta på datorn manuellt med en skruvmejsel där system panel connector ska vara, men det funkar inte heller...',
            '5',
            $now
        ]);
        $this->db->execute([
            '2',
            $heading,
            'PHP,C++,HoN,CSGO,Grafikkort',
            'Hej, detta är en annan fråga om datorkomponenter och andra prylar. Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum ',
            '5',
            $now
        ]);
    }


	/**
	 * Add new user.
	 *
	 * @param string $acronym of user to add.
	 *
	 * @return void
	 */
	public function addAction($acronym = null)
	{
    	$form = new \Anax\HTMLForm\FormAddComment($this->pagekey);
        $form->setDI($this->di);
        $status = $form->check();

        if($this->session->has("user_loggedin"))
        {
        $this->di->views->add('users/form', [
            'title' => "Lägg till kommentar",
            'content' => $form->getHTML(),
            ]);
        }

      	if($status === true) {
    		echo 'true';
    	    $url = $this->url->create('list');
    		$form->response->redirect($url);
    	}
	}

}
