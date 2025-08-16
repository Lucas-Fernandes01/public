const { Component } = require("react");

 // GOOGLE
  function loginWithGoogle() {
    const provider = new firebase.auth.GoogleAuthProvider();
    auth.signInWithPopup(provider)
      .then(result => {
        console.log("Logado com Google:", result.user);
        alert("Login com Google bem-sucedido!");
      })
      .catch(error => {
        console.error("Erro no login com Google:", error);
      });
  }

  // FACEBOOK
  function loginWithFacebook() {
    const provider = new firebase.auth.FacebookAuthProvider();
    auth.signInWithPopup(provider)
      .then(result => {
        console.log("Logado com Facebook:", result.user);
        alert("Login com Facebook bem-sucedido!");
      })
      .catch(error => {
        console.error("Erro no login com Facebook:", error);
      });
  }

  // APPLE (opcional, exige configuração)
  function loginWithApple() {
    alert("Login com Apple ainda não configurado.");
  }
// AUTHENTICATION
   const firebaseConfig = {
    apiKey: "AIzaSyCGOKepunCzj0teRCX_2fwcQEKKiKvDC-o",
    authDomain: "acaidasuica-1420a.firebaseapp.com",
    projectId: "acaidasuica-1420a",
    storageBucket: "acaidasuica-1420a.firebasestorage.app",
    messagingSenderId: "1040820539876",
    appId: "1:1040820539876:web:e03faa8721a39377aff7f1",
    measurementId: "G-F1JLCV5CWP"
  };

   