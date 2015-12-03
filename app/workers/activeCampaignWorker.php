<?php


class activeCampaignWorker {


    /*
     * Update process method
     */
    public function updateProcess($job, $data) {
        Log::info(['UPDATE', $data]);
        $job->delete();
    }


    /*
     * Store process method
     */
    public function storeProcess($job, $data) {
        Log::info(['STORE', $data]);
        $job->delete();
    }


    /*
     * Delete process method
     */
    public function deleteProcess($job, $data) {
        Log::info(['DELETE', $data]);
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

