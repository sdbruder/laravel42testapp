<?php

use AC\ActiveCampaign;

class activeCampaignWorker {

    /*
     * ActiveCampaign method call
     */
    protected function activeCampaignAPI($api, $data) {
        $config_array = Config::get('services.activecampaign');
        $config = new \AC\Arguments\Config($config_array);
        $ac = new ActiveCampaign($config);
        if (!(int)$ac->credentials_test()) {
            Log::info('ActiveCampaign: Access denied, Invalid credentials (URL and/or API key).');
        }
        $result = $ac->api($api, $data);
        if ((int)$result->success) {
                if (property_exists($result, 'subscriber_id')) {
                    Log::info("ActiveCampaign successful API call (ID " . (int)$result->subscriber_id . ")!");
                    return ['ok',  (int)$result->subscriber_id];
                } else {
                    Log::info("ActiveCampaign successful API call. " . var_export($result, true));
                    return ['ok', ''];
                }
        } else {
                Log::info("ActiveCampaign ERROR: API call failed. " . $result->error); // request failed
                return ['error', $result->error];
        }
    }

    /*
     * Update process method
     */
    public function updateProcess($job, $data) {
        //Log::info(['UPDATE', $data]);
        $ac_contact = [
            'id'         => $data['ac_subscriber_id'],
            'email'      => $data['email'],
            'first_name' => $data['name'],
            'last_name'  => $data['surname'],
            'phone'      => $data['phone'],
            'orgname'    => 'Acme, Inc.',
            'tags'       => 'api,test',
            'field[1,0]' => $data['field1'],
            'field[2,0]' => $data['field2'],
            'field[3,0]' => $data['field3'],
            'field[4,0]' => $data['field4'],
            'field[5,0]' => $data['field5'],
            "p[1]"       => 1,
            "status[1]"  => 1, // "Active" status
        ];
        $result = $this->activeCampaignAPI('contact/edit',$ac_contact); // TODO
        if ($result[0] == 'ok') {
            // $contact = Contact::findOrFail($data['id']);
            // $contact->ac_subscriber_id = $result[1];
            // $contact->save();
        } else {
            // error, already logged.
        }
        $job->delete();
    }


    /*
     * Store process method
     */
    public function storeProcess($job, $data) {
        //Log::info(['STORE', $data]);
        $ac_contact = [
            'email'      => $data['email'],
            'first_name' => $data['name'],
            'last_name'  => $data['surname'],
            'phone'      => $data['phone'],
            'orgname'    => 'Acme, Inc.',
            'tags'       => 'api,test',
            'field[1,0]' => $data['field1'],
            'field[2,0]' => $data['field2'],
            'field[3,0]' => $data['field3'],
            'field[4,0]' => $data['field4'],
            'field[5,0]' => $data['field5'],
            "p[1]"       => 1,
            "status[1]"  => 1, // "Active" status
        ];
        $result = $this->activeCampaignAPI('contact/add',$ac_contact);
        if ($result[0] == 'ok') {
            $contact = Contact::findOrFail($data['id']);
            $contact->ac_subscriber_id = $result[1];
            $contact->save();
        } else {
            // error, already logged.
        }
        $job->delete();
    }


    /*
     * Delete process method
     */
    public function deleteProcess($job, $data) {
        // Log::info(['DELETE', $data]);
        $ac_contact = [
            'subscriber_id' => $data['ac_subscriber_id'],
        ];
        $result = $this->activeCampaignAPI('contact/delete', $ac_contact); // TODO
        $job->delete();
    }


    /*
     * ActiveCampaign API firing Job
     */
    public function fire($job, $data) {
        Log::info($data);
        $job->delete();
    }

}

