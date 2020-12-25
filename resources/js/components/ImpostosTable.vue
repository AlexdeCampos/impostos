<template>
    <table class="table table-striped table-hover">
      <thead>
        <th>Id</th>
        <th>UF</th>
        <th>Produto</th>
        <th>Percentual</th>
        <th></th>
      </thead>
      <tbody>
        <tr v-for="imposto in list" :key="imposto.id">
          <td>{{ imposto.id }}</td>
          <td>{{ imposto.uf|states }}</td>
          <td>{{ imposto.produto_id }}</td>
          <td>{{ imposto.percentual|percent }}</td>
          <td>
            <button
              type="button"
              @click="$emit('delete',imposto.id)"
              class="btn btn-error"
            >
              Deletar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
</template>

<script>
export default {
    props:{
        list:{
            required:true,
            type:Array
        }
    }
}
</script>