<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imposto;
use App\Models\Produto;
use Illuminate\Http\Response;

class ImpostoController extends Controller
{
    private $return = [];

    public function getImpostos()
    {
        $impostos = Imposto::all()->sortBy(['uf', 'produto_id']);

        foreach ($impostos as $imposto) {
            $this->return[] = $imposto;
        }

        return \response()->json([
            'data' =>  $this->return,
            'message' => 'Sucesso!!',
        ], Response::HTTP_ACCEPTED);
    }

    public function deleteImposto($id)
    {
        $imposto = Imposto::find($id);

        if ($imposto) {
            $imposto->delete();
            return \response()->json([
                'data' =>  [],
                'message' => 'Imposto deleteado com sucesso!!',
            ], Response::HTTP_ACCEPTED);
            
        } else {
            return \response()->json([
                'data' => [],
                'message' => 'Imposto não encontrado!',
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
                        'data' => $imposto,
                        'message' => 'Sucesso!',
                    ], Response::HTTP_ACCEPTED);
                } else {

                    return \response()->json([
                        'data' => [],
                        'message' => 'Produto inexistente!',
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            } else {
                return \response()->json([
                    'data' => [],
                    'message' => 'Já existe um imposto cadastrado para este produto e uf!',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return \response()->json([
                'data' => [],
                'message' => 'Dados obrigatórios não enviados!',
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
                    'data' =>  $this->return,
                    'message' => 'Sucesso!',
                ], Response::HTTP_ACCEPTED);
            } else {

                return \response()->json([
                    'data' => [],
                    'message' => 'Imposto não cadastrado para produto e uf!',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return \response()->json([
                'data' => [],
                'message' => 'Dados obrigatórios não enviados!',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
