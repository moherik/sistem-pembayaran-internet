<?php

namespace App\Http\Livewire\Packet;

use App\Models\Packet;
use Exception;
use Livewire\Component;

class Form extends Component
{
    public $packetId = null;
    public $formType = null;
    public $label = "";

    public $name = "";
    public $price = "";
    public $speed = "";
    public $description = "";
    public $type = "";

    public $alertType = "";
    public $alertText = "";

    protected $rules = [
        'name' => 'required|min:4',
        'price' => 'required|numeric|min:1',
        'speed' => 'required|numeric|min:1',
        'description' => 'nullable',
        'type' => 'required',
    ];

    protected $messages = [
        'required' => ':attribute tidak boleh kosong.',
        'numeric' => ':attribute harus berupa angka.',
        'min' => 'Nilai untuk :attribute minimal :min.',
    ];

    protected $validationAttributes = [
        'name' => 'Nama paket',
        'price' => 'Harga paket',
        'speed' => 'Kecepatan internet',
        'description' => 'Deskripsi paket',
        'type' => 'Tipe paket'
    ];

    public function mount()
    {
        $availablePath = ['create', 'edit'];
        if (in_array($this->formType, $availablePath, true)) {
            $this->label = $this->formType == 'create' ? 'Tambah Paket' : 'Edit Paket';

            if (isset($this->packetId) && $this->packetId != null) {
                $this->setField($this->packetId);
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function render()
    {
        return view('livewire.packet.form');
    }

    public function savePacket()
    {
        try {
            $data = $this->validate();

            if ($this->formType == 'create') {
                $save = Packet::create($data);
                $this->resetValue();
                $this->setAlert('alert-success', 'Berhasil menyimpan data');
            } else {
                Packet::where('id', $this->packetId)->update($data);
                $this->setAlert('alert-success', 'Berhasil mengubah data paket');
            }
        } catch (Exception $e) {
            $this->setAlert('alert-danger', 'Gagal menyimpan data');
        }
    }

    private function setField($packetId)
    {
        $packet = Packet::where('id', $packetId)->first();
        if ($packet) {
            $this->name = $packet->name;
            $this->price = $packet->price;
            $this->speed = $packet->speed;
            $this->description = $packet->description;
            $this->type = $packet->type;
        }
    }

    private function resetValue()
    {
        $this->resetErrorBag();
        $this->name = "";
        $this->price = "";
        $this->speed = "";
        $this->desc = "";
        $this->type = "";
    }

    private function setAlert($type, $value)
    {
        $this->alertType = $type;
        $this->alertText = $value;
    }
}
