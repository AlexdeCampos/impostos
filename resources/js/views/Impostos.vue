<template>
  <div class="container grid-lg" v-if="!loading">
    <div class="columns">
      <!-- Cadastro de impostos -->
      <div class="column col-md-6 col-sm-12">
        <formulario
          titulo="Cadastro de Impostos"
          @formSubmit="submitNewImposto"
        >
          <div slot="formulario-body">
            <div class="form-group">
              <label class="form-label"> Produto </label>
              <input
                type="text"
                v-model="$v.imposto.produto_id.$model"
                class="form-input"
              />
            </div>
            <div class="form-group">
              <label class="form-label"> UF </label>
              <select v-model="$v.imposto.uf.$model" class="form-select">
                <option :value="null"></option>
                <option v-for="uf in ufs" :key="uf.sigla" :value="uf.sigla">
                  {{ uf.nome }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label"> Percentual </label>
              <money
                class="form-input"
                v-model="$v.imposto.percentual.$model"
                v-bind="percent"
              />
            </div>
          </div>
          <div slot="formulario-footer">
            <button :disabled="disabledImpostoForm" class="btn btn-primary">
              Incluir
            </button>
          </div>
        </formulario>
      </div>
      <!-- Simular impostos -->
      <div class="column col-md-6 col-sm-12">
        <formulario titulo="Simular Imposto" @formSubmit="submitSimularImposto">
          <div slot="formulario-body">
            <div class="form-group">
              <label class="form-label"> Produto </label>
              <input
                type="text"
                v-model="$v.simulacao.produto_id.$model"
                class="form-input"
              />
            </div>
            <div class="form-group">
              <label class="form-label"> UF </label>
              <select
                name="uf"
                v-model="$v.simulacao.uf.$model"
                class="form-select"
              >
                <option :value="null"></option>
                <option v-for="uf in ufs" :key="uf.sigla" :value="uf.sigla">
                  {{ uf.nome }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label"> Preço </label>

              <money
                class="form-input"
                v-model="$v.simulacao.preco.$model"
                v-bind="money"
              />
            </div>
          </div>
          <div slot="formulario-footer">
            <div class="columns">
              <div class="column col-6">
                <button
                  :disabled="disabledSimulacaoForm"
                  class="btn btn-primary"
                >
                  Simular
                </button>
              </div>
              <div class="column col-6 align-center">
                Resultado: {{ dataSimulacao.valor_imposto | currency }}
              </div>
            </div>
          </div>
        </formulario>
      </div>
    </div>
    <impostos-table :list="impostoList" @delete="deletarImposto" />
  </div>
</template>
<script>
import { mapState, mapActions } from "vuex";
import { required } from "vuelidate/lib/validators";
import axios from "axios";
import { VMoney } from "v-money";
import ImpostosTable from "../components/ImpostosTable";
import Formulario from "../components/Formulario";

export default {
  data() {
    return {
      loading: true,
      estado: "",
      imposto: {
        produto_id: null,
        percentual: 0,
        uf: "",
      },
      simulacao: {
        produto_id: null,
        preco: 0,
        uf: "",
      },
      money: {
        decimal: ",",
        thousands: ".",
        prefix: "R$ ",
        suffix: "",
        precision: 2,
      },
      percent: {
        decimal: ",",
        thousands: ".",
        prefix: "",
        suffix: " %",
        precision: 2,
      },
      ufs: [],
    };
  },
  computed: {
    ...mapState("impostos", ["impostoList", "impostoMessage"]),
    ...mapState("simulacao", ["dataSimulacao", "simulacaoMessage"]),
    disabledImpostoForm() {
      return this.$v.imposto.$invalid;
    },
    disabledSimulacaoForm() {
      return this.$v.simulacao.$invalid;
    },
  },
  methods: {
    ...mapActions("impostos", [
      "fetchListaImposto",
      "setImposto",
      "deleteImposto",
    ]),
    ...mapActions("simulacao", ["simularImposto"]),
    async submitNewImposto() {
      try {
        await this.setImposto(this.imposto);
        this.$toaster.success(this.impostoMessage);

        this.imposto = {
          uf: "",
          produto_id: null,
          percentual: 0,
        };
      } catch (error) {
        this.$toaster.error(this.impostoMessage);
      }
    },
    async deletarImposto(id) {
      try {
        await this.deleteImposto(id);
        this.$toaster.success(this.impostoMessage);
      } catch (error) {
        this.$toaster.error(this.impostoMessage);
      }
    },
    async submitSimularImposto() {
      try {
        await this.simularImposto(this.simulacao);
      } catch (error) {
        this.$toaster.error(this.simulacaoMessage);
      }
    },
    async getUf() {
      const { data } = await axios.get(
        "http://servicodados.ibge.gov.br/api/v1/localidades/estados/"
      );
      this.ufs = data;
    },
  },
  async created() {
    await this.fetchListaImposto();
    await this.getUf();
    this.loading = false;
  },
  validations: {
    imposto: {
      produto_id: {
        required,
      },
      percentual: {
        required,
      },
      uf: {
        required,
      },
    },
    simulacao: {
      produto_id: {
        required,
      },
      preco: {
        required,
      },
      uf: {
        required,
      },
    },
  },
  components: {
    ImpostosTable,
    Formulario,
  },
};
</script>
<style scoped>
  .container {
    padding: 10px;
  }

  .align-center {
    display: flex;
    align-items: center;
  }
</style>