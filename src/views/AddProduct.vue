<template>
  <div class="container">
      <header>
          <div>
              <h2>Product Add</h2>
          </div>
      </header>
      <div class="errors">
          <span v-for="error in errors" :key="error.id"><span id="star">*</span> {{error}}<br></span>
      </div>
      <div class="form" >
          <form action="" id="product_form" @submit.prevent="addProduct()">
              <div class="flex">
                  <div>
                    <label for="sku">#SKU</label>
                    <input type="text" id="sku"  placeholder="SKU" v-model="sku" >
                  </div>
                  <div>
                    <label for="name">Name</label>
                    <input type="text" id="name" placeholder="name" v-model="name" >
                  </div>
                  <div>
                    <label for="price">Price  </label>
                    <input type="text" id="price" placeholder="price" v-model="price" >
                  </div>
              </div>


              <div>
                  <select v-model="type" name="type" id="productType" @change="getAttributes($event)" >
                          <option selected value="0" >Type</option>
                          <option :key="item.id" v-for="item in types" :value="item.id" :id="item.name" >{{item.name}}</option>
                  </select>
              </div>

              <div  v-for="attribute in attributes" :key="attribute.id" :id="attribute.id">
                  <span>{{attribute.name}} ({{attribute.unit}}) </span> 
                  <input :id="attribute.name"  class="input-field" name="field1" type="text"   v-model="attribute.value">
              </div>
              <p>{{type.description}}</p>
              <div class="btns-div">
                <button class="btn" @click="addProduct()" type="Submit">Save</button>
                <button class="btn" @click="back()">Cancel</button>
              </div>
          </form>
      </div>
  </div>
</template>



<script>
import axios from 'axios';

export default {
  name: "AddProduct",
  data(){
      return {
          name:'',
          sku:'',
          price: '',
          type: '0',
          errors: [],
          attributes: [],
          type_value: 'Type',
          types: [],
          err: []
          }
          
      },
  methods: { 
          back(){
                  this.$router.push("/");
              },
          addProduct(){
                  var data = new FormData();
                  data.append("sku", this.sku);
                  data.append("name", this.name);
                  data.append("price", this.price);
                  data.append("type", this.type_value);
                  data.append("attributes", JSON.stringify(this.attributes));
                  for (const key in this.attributes) {
                          data.append(this.attributes[key].name,this.attributes[key].value);
                      }
                  axios
                  .post('https://tight-laced-damages.000webhostapp.com/back_end/public/home/addProduct',data)
                  .then(res => { 
                      if(res.data.errors){
                          this.errors = res.data.errors;
                      }else{
                          this.back();
                      }
                  })
                  .catch(err => (this.err = err.data))
              


          }
          ,getAttributes(event){
              let type_id = event.target.value;
              this.type_value = event.target.options[event.target.options.selectedIndex].text;
              axios
              .get('https://tight-laced-damages.000webhostapp.com/back_end/public/home/getAttributes&type_id='+type_id)
              .then(res =>{
                  (this.attributes = res.data)
                  })
              .catch(err => {console.log("Error", err);});
                  
          }
        

  },mounted()
  {
      // this.getTypes();          
              axios
              .get('https://tight-laced-damages.000webhostapp.com/back_end/public/home/getTypes')
              .then(res => {
                  this.types = res.data;
              })
              .catch(err => {console.log("Error", err);});

        
      

  }
}

</script>



<style scoped>
.container {
  position: relative;
  height: 100vh;
  overflow: hidden;
  background-image: url("images/background.jpeg");
  background-position: center;
  background-size: 300px;
  background-repeat: no-repeat;
}
header{
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
header h2 {
  margin-left: 20px; 
}
.btn {
  color: #fff;
  border: none;
  background-color: #e67e22;
  padding: 5px;
  cursor: pointer;
  
}
.btn a {
  text-decoration: none;
  color: #fff;
}

form {
  width: 500px;
  margin: 50px 20px;
}
form .flex {
  display: flex;
  flex-direction: column;
}
select {
  margin: 50px 50px;
}
.flex div input {
  width: 80%;
}
.btns-div button {
  margin: 20px;
}
form input,select {
  margin-bottom: 5px;
  padding: 4px;
}
label {
  margin-right: 10px;
}
.errors {
  position:absolute;
  top: 90px;
  right: 30%;
} 
#star {
  color: red;
  line-height: 25px;

  transition: 0.4s;
  transition-delay: 2s;
  transition-property: all;
  transition-timing-function: ease-in-out;
}
.hide {
  display: none;
}




</style>