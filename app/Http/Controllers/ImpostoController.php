<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Imposto;
use App\Models\Produto;

class ImpostoController extends Controller
{
    private $return = [];
    public function index()
    {
        $data = [
            "estados" => $this->getUF()
        ];

        return view('impostos', $data);
    }

    public function getImpostos()
    {
        $impostos = Imposto::all()->sortBy(['uf', 'produto_id']);

        foreach ($impostos as $imposto) {
            $this->return[] = $imposto;
        }
        return $this->return;
    }

    public function deleteImposto($id)
    {
        $imposto = Imposto::find($id);

        if ($imposto) {
            $imposto->delete();
            $this->return = "Imposto deleteado com sucesso!";
        } else {
            $this->return = "Imposto não encontrado!";
        }

        return $this->return;
    }

    public function setImposto(Request $request)
    {
        $idProduto = $request->input('produto_id');
        $percentual = $request->input('percentual');
        $uf = $request->input('uf');

        if ($idProduto && $percentual && $uf) {
            $count = Imposto::where('produto_id', $idProduto)->where('uf', $uf)->count();
            if ($count == 0) {

                $produto = Produto::find($idProduto);

                if ($produto) {
                    $imposto = new Imposto();
                    $imposto->uf = $uf;
                    $imposto->produto_id = $idProduto;
                    $imposto->percentual = $percentual;
                    $imposto->save();
                    $this->return = "Sucesso!";
                } else {
                    $this->return = "Produto inexistente!";
                }
            } else {
                $this->return = "Já existe um imposto cadastrado para este produto e uf!";
            }
        } else {
            $this->return = "Dados obrigatórios não enviados!";
        }
        return $this->return;
    }

    public function getCalculoimposto(Request $request)
    {
        $produto_id = $request->input('produto_id');
        $preco = $request->input('preco');
        $uf = $request->input('uf');

        if ($produto_id && $preco && $uf) {
            $imposto = Imposto::where('produto_id', $produto_id)->where('uf', $uf)->first();
            if ($imposto->count() > 0) {
                $percentual = (float) $imposto->percentual;
                $valor_imposto = ($preco / 100) *  $percentual;

                $this->return = [
                    "uf" => $uf,
                    "produto_id" => $produto_id,
                    "preco" => $preco,
                    "valor_imposto" => $valor_imposto
                ];
            } else {
                $this->return = "Imposto não cadastrado para produto e uf!";
            }
        } else {
            $this->return = "Dados obrigatórios não enviados!";
        }
        return $this->return;
    }

    //Retorna a sigla de todos os Estado existentes
    public function getUF(){
         $estados = json_decode(Http::get('http://servicodados.ibge.gov.br/api/v1/localidades/estados/'));
        foreach ($estados as $estado){
            $this->return[] = $estado->sigla;
        }

        return $this->return;
    }
}
