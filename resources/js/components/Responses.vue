<template>
  <div class="row">
    <a href="#" class="btn btn-outline-primary" v-on:click="load">Show responses</a>
    <div class="col-md-12">
    <div class="card  mt-2" v-for="response in responses">
      <div class="card-header">
        {{ response.user.username}} says:
      </div>
      <div class="card-body">
        {{ response.message }}
      </div>
      <div class="card-footer text-muted">
        {{ response.created_at }}
      </div>
    </div>
  </div>
  </div>

</template>

<script>
export default{
  props: ['message'],
  data(){
    return{
      responses:[],
    }
  },

  methods: {
    load(){
      axios.get('/api/messages/' + this.message + '/responses')
      .then(res => {
        this.responses = res.data;
      });
    }
  }
}

</script>
