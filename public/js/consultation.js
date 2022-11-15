var app = new Vue({
  el: '#invoice',
  data: {
    isProcessing: false,
    form: {},
    errors: {}
  },
  created: function () {
    Vue.set(this.$data, 'form', _form);
  },
  methods: {
    addLine: function() {
      this.form.products.push({product_id:0, name: '', price: 0, qty: 1, total:0});
      vm.$forceUpdate();
      
      $("#items").val(JSON.stringify(this.form.products));

      
    },
    loadLine: function(){
        $('select.product').on('change',function(){

          var name= $(this).find('option:selected').data('name');
          $(this).next('input.product').val(name).change();


          var price = $(this).children('option:selected').data('price');
          $(this).parent().parent().next().find('.price').val(price).change();

      })
      $('select.product').change();
    },
    remove: function(product) {
      this.form.products.$remove(product);
      $("#items").val(JSON.stringify(this.form.products));
    },
    create: function() {
      this.isProcessing = true;
      this.$http.post('/invoices', this.form)
        .then(function(response) {
          if(response.data.created) {
            alert(response.data.created);
            window.location = '/invoices/' + response.data.id;
          } else {
            this.isProcessing = false;
          }
        })
        .catch(function(response) {
          this.isProcessing = false;
          Vue.set(this.$data, 'errors', response.data);
        })
    },
    update: function() {
      this.isProcessing = true;
      this.$http.put('/invoices/' + this.form.id, this.form)
        .then(function(response) {
          if(response.data.updated) {
            window.location = '/invoices/' + response.data.id;
          } else {
            this.isProcessing = false;
          }
        })
        .catch(function(response) {
          this.isProcessing = false;
          Vue.set(this.$data, 'errors', response.data);
        })
    }
  },
  computed: {
    subTotal: function() {
      $(".total").change();
      $("#items").val(JSON.stringify(this.form.products));

      return this.form.products.reduce(function(carry, product) {
        return carry + (parseFloat(product.qty) * parseFloat(product.price));
      }, 0);
    },
    grandTotal: function() {
      return this.subTotal - parseFloat(this.form.discount);
    }
  }
})