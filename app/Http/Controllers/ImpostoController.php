<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Imposto;
use App\Models\Produto;
use Illuminate\Http\Response;

class ImpostoController extends Controller
{
    private $return = [];
    public function index()
    {
        return view('impostos');
    }

    public function getImpostos()
    {
        $impostos = Imposto::all()->sortBy(['uf', 'produto_id']);

        foreach ($impostos as $imposto) {
            $this->return[] = $imposto;
        }

        return \response()->json([
            'data' =>  $this->return, //sample entry
            'message' => 'Sucesso!!', //sample message
        ], Response::HTTP_ACCEPTED);
    }

    public function deleteImposto($id)
    {
        $imposto = Imposto::find($id);

        if ($imposto) {
            $imposto->delete();
            return \response()->json([
                'data' =>  $this->return, //sample entry
                'message' => 'Imposto deleteado com sucesso!!', //sample message
            ], Response::HTTP_ACCEPTED);
        } else {
            return \response()->json([
                'data' => [], //sample entry
                'message' => 'Imposto não encontrado!', //sample message
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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

                    return \response()->json([
                        'data' => $imposto, //sample entry
                        'message' => 'Sucesso!', //sample message
                    ], Response::HTTP_ACCEPTED);
                } else {

                    return \response()->json([
                        'data' => [], //sample entry
                        'message' => 'Produto inexistente!', //sample message
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            } else {
                return \response()->json([
                    'data' => [], //sample entry
                    'message' => 'Já existe um imposto cadastrado para este produto e uf!', //sample message
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return \response()->json([
                'data' => [], //sample entry
                'message' => 'Dados obrigatórios não enviados!', //sample message
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getCalculoimposto(Request $request)
    {
        $produto_id = $request->input('produto_id');
        $preco = $request->input('preco');
        $uf = $request->input('uf');

        if ($produto_id && $preco && $uf) {
            $imposto = Imposto::where('produto_id', $produto_id)->where('uf', $uf)->first();
            if ($imposto) {
                $percentual = (float) $imposto->percentual;
                $valor_imposto = ($preco / 100) *  $percentual;

                $this->return = [
                    "uf" => $uf,
                    "produto_id" => $produto_id,
                    "preco" => $preco,
                    "valor_imposto" => $valor_imposto
                ];

                return \response()->json([
                    'data' =>  $this->return, //sample entry
                    'message' => 'Sucesso!', //sample message
                ], Response::HTTP_ACCEPTED);
            } else {

                return \response()->json([
                    'data' => [], //sample entry
                    'message' => 'Imposto não cadastrado para produto e uf!', //sample message
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return \response()->json([
                'data' => [], //sample entry
                'message' => 'Dados obrigatórios não enviados!', //sample message
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //Retorna a sigla de todos os Estado existentes
    public function getUF()
    {
        $estados = json_decode(Http::get('http://servicodados.ibge.gov.br/api/v1/localidades/estados/'));
        foreach ($estados as $estado) {
            $this->return[] = $estado->sigla;
        }

        return $this->return;
    }
}
