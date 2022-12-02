<?php 

    namespace common\components\zoom;


    use Yii;
    use yii\base\Component;




    class zoomComponent extends Component {


        /**
         * @var null
         */
        private $apiKey = null;

        /**
         * @var null
         */
        private $apiSecret = null;

        /**
         * @var null
         */
        private $users = null;

        /**
         * @var null
         */
        private $meetings = null;

        /**
         * Zoom constructor.
         * @param $apiKey
         * @param $apiSecret
         */
        public function __construct( $apiKey, $apiSecret ) {

            $this->apiKey = $apiKey;

            $this->apiSecret = $apiSecret;

            $this->getInstance();

        }

        /**
         * Retorna uma instância única de uma classe.
         *
         * @staticvar Singleton $instance A instância única dessa classe.
         *
         * @return Singleton A Instância única.
         */
        public function getInstance()
        {
            static $users = null;
            if (null === $users) {
                $this->users = new zoomUsersComponent($this->apiKey, $this->apiSecret);
            }

            static $meetings = null;
            if (null === $meetings) {
                $this->meetings = new zoomMeetingsComponent($this->apiKey, $this->apiSecret);
            }

            return $users;
        }

        /*Functions for management of users*/

        public function createUser($email,$first_name,$last_name,$tipo){
            $createAUserArray['action'] = 'create';
            //$createAUserArray['email'] = $_POST['email'];
            //$createAUserArray['email'] = $email;
            $createAUserArray['user_info']['email'] = $email;
            $createAUserArray['user_info']['first_name'] = $first_name;
            $createAUserArray['user_info']['last_name'] = $last_name;
            $createAUserArray['user_info']['type'] = $tipo;
            //$createAUserArray['user_info'] = $_POST['user_info'];



            return $this->users->create($createAUserArray);
        }

        public function listUsers(){
            $createAUserArray['action'] = 'list';
            // //$createAUserArray['email'] = $_POST['email'];
            // $createAUserArray['email'] = "csantibanez@pedrodevaldivia.cl";
            // $createAUserArray['user_info'] = "user_info";
            // //$createAUserArray['user_info'] = $_POST['user_info'];

            return $this->users->list($createAUserArray);
        }

        public function meUsers(){
            $createAUserArray['action'] = 'me';
            // //$createAUserArray['email'] = $_POST['email'];
            // $createAUserArray['email'] = "csantibanez@pedrodevaldivia.cl";
            // $createAUserArray['user_info'] = "user_info";
            // //$createAUserArray['user_info'] = $_POST['user_info'];

            return $this->users->list($createAUserArray);
        }

        public function buscarUsuarioEmail($email){
            // $createAUserArray['action'] = 'email';
            // // //$createAUserArray['email'] = $_POST['email'];
            // $createAUserArray['email'] = "csantibanez@pedrodevaldivia.cl";
            // $createAUserArray['user_info'] = "user_info";
            // //$createAUserArray['user_info'] = $_POST['user_info'];

            return $this->users->email($email);
        }

        public function eliminarUsuario($id_zoom){
            // $createAUserArray['action'] = 'email';
            // // //$createAUserArray['email'] = $_POST['email'];
            // $createAUserArray['email'] = "csantibanez@pedrodevaldivia.cl";
            // $createAUserArray['user_info'] = "user_info";
            // //$createAUserArray['user_info'] = $_POST['user_info'];

            return $this->users->remove($id_zoom);
        }

        public function agregarCoAnfitrion($id_zoom){
            // $createAUserArray['action'] = 'email';
            // // //$createAUserArray['email'] = $_POST['email'];
            // $createAUserArray['email'] = "csantibanez@pedrodevaldivia.cl";
            // $createAUserArray['user_info'] = "user_info";
            // //$createAUserArray['user_info'] = $_POST['user_info'];

            //return $this->users->remove($id_zoom);
        }

        public function verMeeting($id_zoom){
            // $createAUserArray['action'] = 'email';
            // // //$createAUserArray['email'] = $_POST['email'];
            // $createAUserArray['email'] = "csantibanez@pedrodevaldivia.cl";
            // $createAUserArray['user_info'] = "user_info";
            // //$createAUserArray['user_info'] = $_POST['user_info'];

            return $this->meetings->meeting($id_zoom);
        }
        

        public function listarMeetings($idUsuario){
            // $createAUserArray['action'] = 'email';
            // // //$createAUserArray['email'] = $_POST['email'];
            // $createAUserArray['email'] = "csantibanez@pedrodevaldivia.cl";
            // $createAUserArray['user_info'] = "user_info";
            // //$createAUserArray['user_info'] = $_POST['user_info'];

            return $this->meetings->list($idUsuario);
        }

        public function crearMeetings($idUsuario,$nombre,$fecha){
            $createAUserArray['topic'] = $nombre;
            //$createAUserArray['email'] = $_POST['email'];
            //$createAUserArray['email'] = $email;
            $createAUserArray['start_time'] = $fecha;
            $createAUserArray['timezone'] = "America/Santiago";
            $createAUserArray['duration'] = 80;
            //$createAUserArray['userId'] = $idUsuario;

            //$createAUserArray['user_info'] = $_POST['user_info'];

            return $this->meetings->create($idUsuario,$createAUserArray);
        }

        public function eliminarMeeting($idMeeting){

            return $this->meetings->remove($idMeeting);

        }

    }

?>

