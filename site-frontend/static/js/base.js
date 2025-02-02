document.addEventListener('DOMContentLoaded', () => {  

    var botao_adicionarAoCarrinho = document.getElementsByClassName('botaoAdicionarAoCarrinho')[0]; //ADICIONAR AO CARRINHO
    var botao_comprarAgora = document.getElementsByClassName('botaoComprarAgora')[0];
    var botoes_removerDoCarrinho = document.getElementsByClassName('botaoRemoverDoCarrinho'); //LIXEIRA
  
    var botoes = [botao_adicionarAoCarrinho, botao_comprarAgora, ...botoes_removerDoCarrinho];
  
  
   
    botoes.forEach(function(botao) {
      if (botao != undefined){
          botao.addEventListener('click', function() {     
              var id = this.dataset.id;
              var action = this.dataset.action;
  
              //Objeto lidado: ItemCarrinho
              if (action === 'deletar') {
                  var quantidadeAdicionada = document.getElementById(`quantity${id}`).value;
              }
              //Objeto lidado: Livro
              else { 
                  var quantidadeAdicionada = document.getElementById(`quantity`).value;
              } 
              
              updateUserCart(id, action, quantidadeAdicionada);
          });
      }
      
  });
  
    //Objeto lidado: ItemCarrinho
    document.querySelectorAll('.quantity-btn').forEach(button => {
      button.addEventListener('click', function() {
          console.log("Quantity button clicked"); 
          const quantityInput = this.parentElement.querySelector('input');
          let currentValue = parseInt(quantityInput.value);
          var action = this.dataset.action;
          var id = quantityInput.dataset.id;
          console.log("Quantity input", quantityInput);
          console.log("Action", action);
          console.log("Id", id);
          console.log("Currentvalue", currentValue);
          const max = parseInt(quantityInput.getAttribute('max'));
          const min = parseInt(quantityInput.getAttribute('min'));
  
          if (this.classList.contains('minus') && currentValue > min) {
              quantityInput.value = currentValue - 1;
            
              console.log("Minus");
              console.log(quantityInput.value);
            } else if (this.classList.contains('plus') && currentValue < max) {
              quantityInput.value = currentValue + 1;
              
              console.log("Plus");
              console.log(quantityInput.value);
            }
          
  
          if (action == 'remover' || action == 'adicionar') {
            console.log("Ação de adicionar ou remover uma unidade de livro")
            console.log("Id", id);
            console.log("Action", action);
            console.log("Quantity", quantityInput.value);
            updateUserCart(id, action, quantityInput.value);
          }
          
      });
    });
   
  
    const selectAllCheckbox = document.getElementById('myCheckbox');
    const checkboxes = document.querySelectorAll('.custom-checkbox');
  
    if (selectAllCheckbox) {
      selectAllCheckbox.addEventListener('change', () => {
        checkboxes.forEach(checkbox => {
          checkbox.checked = selectAllCheckbox.checked;
        });
      });
    }
  
    function updateUserCart(id, action, quantidadeAdicionada){
      var url = 'adicionar_carrinho.php';
     
      
      fetch(url, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
          },
          body: JSON.stringify({'id': id, 'action': action, 'quantidadeAdicionada': quantidadeAdicionada}),
      })
      .then((response) => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
      }
      return response.json();
      })
      .then((data) => {
          
          console.log('Data:', data);
          if (data.redirect) {
              window.location.href = data.url;
          } else {
              
              console.log("Data message", data.message);
              if (action === 'deletar') {
                  var itemElement = document.querySelector(`button[data-id="${id}"]`).closest('li');
                  itemElement.remove();

  

                  
              }
  
              var cartItemCountElement = document.querySelector('.carrinho-quantidade');
              if (data.cartItemCount >= 10) {
                  cartItemCountElement.textContent = '+9';
              } else {
                  cartItemCountElement.textContent = data.cartItemCount;
              }
            
            
          }
      });
    }
  
  
  
  });