<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Formatacao;
use App\User;
use Config;

class AsaasTransacao extends Model
{
    protected $table;
    protected $fillable;
    public $timestamps = false;

    public function __construct(){
    	$this->table = "asaas_transacoes";
        //$this->fillable = ['dateCreated', 'customer', 'subscription', 'telefone', 'imagem', 'ativo'];
    }
}