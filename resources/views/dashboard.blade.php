
<x-app-layout>
    <!-- Top nav-->
    <x-header></x-header>
    <!--aside-menu>-->
    <x-aside-menu :imageUrl="$imageUrl"></x-aside-menu>

<script>
    const sidebar = document.getElementById('contenedor-img');
    const imagenPrincipal = document.getElementById('img-principal');
    const button = document.getElementById('button');
    const images = sidebar.querySelectorAll('img');
    const imageTrain = document.getElementById('image-train');
    const imageTest = document.getElementById('image-test');
    const mainContent = document.getElementById('main-content');
  
    let previousContainer = null; // ← Guarda el contenedor anterior
  
    // Manejar selección de imagen
    images.forEach(img => {
      img.addEventListener('click', (e) => {
        images.forEach(image => {
          image.classList.remove('border-2', 'border-blue-500');
        });
        e.target.classList.add('border-2', 'border-blue-500');
        imagenPrincipal.src = e.target.src;
      });
    });
  
    button.addEventListener('click', async () => {
      const selectedImage = document.querySelector('.border-2.border-blue-500');
  
      if (!selectedImage) {
        alert('Por favor, selecciona una imagen de estilo.');
        return;
      }
  
      // Elimina la imagen mostrada anteriormente, si existe
      if (previousContainer) {
        previousContainer.remove();
      }
      button.disabled = true;
      button.innerText = 'Generating...';
      // Crear nuevo contenedor con la imagen seleccionada
      imageTrain.src = selectedImage.src;
      try {
        const imageUrl = selectedImage.src;
        const response= await fetch('/procesar-imagen',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ 
                image_url: imageUrl
             })


        });
        console.log(response);
        
        const data = await response.json();
        console.log(data);
        if(data.success){
            imageTest.src = data.processed_image;
        }
        else{
            alert('Error al procesar la imagen'+data.message);
        }
    }
    catch(error){
        console.error('error:', error);
    }
    finally{
        button.disabled = false;
        button.innerText = 'Generate';
    }
  
    });
  </script>
</x-app-layout>
