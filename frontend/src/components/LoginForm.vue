<template>
    <div class="login-wrapper">
      <div class="login-left">
        BURSZTYN-25
      </div>
      <form class="login-right" @submit.prevent="login">
        <div class="form-group">
          <input type="text" id="username" placeholder=" " v-model="username" required>
          <label for="username">Użytkownik</label>
        </div>
        <div class="form-group">
          <input type="password" id="password" placeholder=" " v-model="password" required>
          <label for="password">Hasło</label>
        </div>
        <div class="checkbox-container">
          <input type="checkbox" id="rememberMe" v-model="rememberMe">
          <label for="rememberMe">Zapamiętaj</label>
        </div>
        <button class="btn btn-primary" type="submit">Login</button>
      </form>
    </div>
</template>

<script>
import axios from "axios";
export default {
  name: "LoginForm",
  data() {
    return {
      rememberMe: false,
      username: "",
      password: ""
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post("http://api2.wisksolution.com/login", {
          username: this.username,
          password: this.password
        });
        alert("Login successful! " + response.data);
      } catch (error) {
        alert("Login failed: " + error.message);
      }
    }
  }
};
</script>

<style scoped>

</style>
