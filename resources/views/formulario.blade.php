<x-app-layout>
    <div class="flex h-screen">
      
      <!-- Sidebar -->
      <div class="bg-gray-900 text-white w-72 h-full p-4 flex flex-col space-y-4" id="sidebar">
        <!-- Título -->
        <div class="flex justify-between items-center">
          <h2 class="text-lg font-semibold">Reimagine</h2>
          <button class="text-white text-xl font-bold">⋮</button>
        </div>
  
        <!-- Imagen -->
        <div class="w-full h-40 bg-gray-700 rounded overflow-hidden flex items-center justify-center">
          <img  id="img-principal" src="https://static4.depositphotos.com/1015265/305/i/450/depositphotos_3054488-stock-photo-stunning-waterfall.jpg" alt="User" class="object-cover h-full w-full">
        </div>
  
        <!-- Selección de estilo -->
        <div>
          <p class="text-sm font-medium mb-2">Select style</p>
          <div class="grid grid-cols-3 gap-2" id="contenedor-img">
  
            @foreach ($imageUrl as $url)
              <div class="text-center rounded">
                <img src="{{ $url }}" class="w-full h-20 object-cover rounded mb-1 border">
              </div>
            @endforeach
          </div>
        </div>
  
        <!-- Botón generar -->
        <button  id="button" class="mt-auto bg-purple-600 hover:bg-purple-700 text-white py-2 rounded text-center">
          Generate
        </button>
      </div>
  
      <!-- Contenido principal -->
      <div class="flex-1 overflow-y-auto p-6 bg-gray-100" id="main-content">
        <form class="max-w-lg mx-auto" action="/formulario" method="POST" enctype="multipart/form-data">
          @csrf
          @method('POST')
          <h1 class="text-2xl font-bold mb-4">Formulario de carga de imagen</h1>
  
          <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Upload file</label>
          <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="user_avatar" name="image" type="file">
          <div class="mt-1 text-sm text-gray-500 dark:text-gray-300">A profile picture is useful to confirm your are logged into your account</div>
  
          <buttontype="submit" class="mt-4 px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Submit</button>
  
          @if(isset($image))
          <div class="flex justify-center mt-4">
            <img src="{{ $image }}" alt="Imagen enviada" class="w-1/2 h-auto rounded-lg shadow-lg"/>
          </div>
          @endif
        </form>
      </div>
  
    </div>
    
<script>
      const sidebar = document.getElementById('contenedor-img');
  const imagenPrincipal = document.getElementById('img-principal');
  const button = document.getElementById('button');
  const images = sidebar.querySelectorAll('img');
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

  button.addEventListener('click', () => {
    const selectedImage = document.querySelector('.border-2.border-blue-500');

    if (!selectedImage) {
      alert('Por favor, selecciona una imagen de estilo.');
      return;
    }

    // Elimina la imagen mostrada anteriormente, si existe
    if (previousContainer) {
      previousContainer.remove();
    }

    // Crear nuevo contenedor con la imagen seleccionada
    const container = document.createElement('div');
    container.classList.add('flex', 'justify-center', 'mt-4');
    container.innerHTML = `<img src="${selectedImage.src}" alt="Imagen seleccionada" class="w-1/2 h-auto rounded-lg shadow-lg"/>`;

    // Guardar referencia al contenedor actual
    previousContainer = container;

    // Agregarlo al contenido principal
    mainContent.appendChild(container);
  });
</script>
  </x-app-layout>
  