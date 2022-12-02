<?php 

    namespace common\components\zoom;


    use Yii;
    use common\components\zoom\zoomRequestComponent;

    class zoomReportsComponent extends zoomRequestComponent {

        /**
         * Meetings constructor.
         * @param $apiKey
         * @param $apiSecret
         */
        public function __construct($apiKey, $apiSecret) {
            parent::__construct($apiKey, $apiSecret);
        }

        /**
         * Meeting Participants
         *
         * @param $meetingUUID
         * @param array $query
         * @return array|mixed
         */
        public function meetingParticipants(string $meetingUUID, array $query = []) {
            return $this->get("report/meetings/{$meetingUUID}/participants", $query);
        }

    }

?>

