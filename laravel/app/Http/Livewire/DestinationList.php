<?php

namespace App\Http\Livewire;

use App\Models\Destination;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class DestinationList extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $open=false;
    public $name;
    public $destination_url_conn;

    public $active;
    public $search;
    public $destination_url;
    public $id_model=0;

    public function render()
    {

        $search = '%'.$this->search.'%';

        return view('livewire.destinations.index',[
            'destinations' => Destination::where('name','like',$search)->where('user_id',Auth::user()->id)->paginate(5),
            'count'         => Destination::where('user_id',Auth::user()->id)->count()
        ]);
    }

    public function create()
    {
        $this->resetFields();
        $this->open();
    }

    public function open()
    {
        $this->resetErrorBag();
        $this->resetFields();
        $this->open = true;
    }

    public function close()
    {

        $this->open = false;
        $this->resetFields();
        $this->resetErrorBag();

    }

    public function resetFields()
    {
        $this->name        = '';
        $this->destination_url = '';
        $this->destination_url_conn = '';
        $this->active      = true;
    }

    public function delete($id){
        $destination = Destination::find($id);
        $destination->delete();
        $this->alert('success', 'Η διαγραφή ολοκληρώθηκε',[
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function store()
    {



        $this->validate([
            'name'   => 'required',
            'destination_url_conn' => 'required|unique:destinations|url',
            'destination_url' => 'required|url|unique:destinations'
        ]);
        ini_set("allow_url_fopen", 1);

        $check_connector = $this->get($this->destination_url_conn);
        if (isset($check_connector['status']) && $check_connector['status']){
            $type = 'success';
            $message = 'Η καταχώρηση ολοκληρώθηκε';

            Destination::updateOrCreate(['id' => $this->id_model], [
                'name'                  => $this->name,
                'destination_url'          => $this->destination_url,
                'active'                => $this->active,
                'user_id'               => Auth::user()->id,
                'destination_url_conn'              => $this->destination_url_conn
            ]);

            $this->close();
        }else{
            $type = 'warning';
            $message = $check_connector['message'];
            $this->close();
        }


        $this->alert($type, $message,[
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
    }


    private function request($method, $endpoint, $data = null)
    {
        $url = $endpoint;
        $ch = curl_init($url);
        $headers = [
            'Content-Type: application/json',
        ];

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            throw new Exception('Request Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $this->handleResponse($response, $httpCode);
    }

    private function handleResponse($response, $httpCode)
    {
        if ($httpCode >= 200 && $httpCode < 300) {
            return json_decode($response, true);
        } else {
            throw new Exception("HTTP error: $httpCode - " . $response);
        }
    }


    public function api_v1($endpoints)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $endpoints);
        $result = curl_exec($ch);
        curl_close($ch);
        if (! $result) {
            return false;
        }

        $json = json_decode(utf8_encode($result));
        if (empty($json) || json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        return  $json;
    }

    public function get($endpoint, $params=[])
    {
        if ($params) {
            $endpoint .= '?' . http_build_query($params);
        }
        return $this->request('GET', $endpoint);
    }

    public function status($id)
    {
        $destination = Destination::find($id);
        $destination->active = $destination->active == 1 ? 0 : 1;
        $destination->save();
        $this->alert('success', "Η κατάσταση ενημερώθηκε",[
            'position' => 'top-right',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
}
