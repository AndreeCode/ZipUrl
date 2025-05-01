<template>
    <div class="max-w-4xl mx-auto p-6">
      <h1 class="text-5xl font-bold mb-2 text-center text-blue-600">ZipUrl</h1>
      <p class="text-xl font-semibold text-center text-gray-600">Acortador de URLs</p>
  
      <div class="mb-6">
        <input
          v-model="nuevaUrl.url"
          class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Ingresa la URL original"
        />
      </div>
      <div class="mb-6">
        <button
          @click="crear"
          class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          Crear URL corta
        </button>
      </div>
  
      <div class="mb-6">
        <input
          v-model="verId"
          class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          placeholder="Ingresa el Short de la url corta"
        />
      </div>
      <div class="mb-6">
        <button
          @click="obtener"
          class="w-full bg-green-500 text-white p-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500"
        >
          Ver URL desde backend
        </button>
      </div>
  
      <div v-if="shortUrl" class="mt-6">
        <p class="text-lg font-semibold">URL corta creada:</p>
        <a :href="shortUrl" class="text-blue-500 hover:underline" target="_blank">{{ shortUrl }}</a>
      </div>
  
      <h3 class="text-xl font-semibold mt-8 mb-4">Rutas y Alias existentes:</h3>
      <div class="max-h-64 overflow-y-auto border border-gray-300 rounded-md shadow-sm">
        <table class="min-w-full table-auto">
          <thead class="bg-gray-100 sticky top-0 z-10">
            <tr>
              <th class="p-3 text-left font-semibold text-gray-700">Alias / URL original</th>
              <th class="p-3 text-left font-semibold text-gray-700">Short URL</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(ruta, index) in rutas" :key="index" class="border-t border-gray-200 hover:bg-gray-50">
              <td class="p-3 align-top">
                <p class="font-semibold text-blue-600 break-all">
                  <a :href="ruta.alias" target="_blank">{{ ruta.alias }}</a>
                </p>
                <p class="text-sm text-gray-600 break-all">
                  <a :href="ruta.original_url" target="_blank">{{ ruta.original_url }}</a>
                </p>
              </td>
              <td class="p-3 align-top text-green-700 break-all">
                <p>
                  <a :href="ruta.short_url" target="_blank" class="hover:underline">
                    {{ ruta.short_url }}
                  </a>
                </p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <p v-if="rutas.length === 0" class="mt-6 text-center text-gray-600">No hay rutas disponibles.</p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  
  const nuevaUrl = ref({ url: '' });
  const verId = ref('');
  const resultado = ref(null);
  const rutas = ref([]);
  const shortUrl = ref('');
  
  const crear = async () => {
    try {
      const res = await axios.post('/api/urls', nuevaUrl.value);
      shortUrl.value = res.data.short_url;
      resultado.value = `URL corta creada: ${shortUrl.value}`;
      nuevaUrl.value.url = '';
      obtenerRutas();
    } catch (err) {
      resultado.value = err.response?.data || err.message;
    }
  };
  
  const obtener = () => {
    if (verId.value) {
      window.location.href = `/${verId.value}`;
    } else {
      resultado.value = 'ID no válido';
    }
  };
  
  const obtenerRutas = async () => {
    try {
      const res = await axios.get('/api/showUrls');
      rutas.value = res.data;
    } catch (err) {
      console.error("Error al obtener rutas:", err.message);
    }
  };
  
  obtenerRutas();
  </script>
  
  <style scoped>
  ul {
    padding: 0;
    margin: 0;
    list-style-type: none;
  }
  
  li {
    display: flex;
    flex-direction: column;
    padding: 12px 0;
    border-bottom: 1px solid #e5e7eb;
  }
  
  li:last-child {
    border-bottom: none;
  }
  
  a {
    text-decoration: none;
  }
  
  a:hover {
    text-decoration: underline;
  }
  
  .max-h-60 {
    max-height: 15rem;
  }
  
  .overflow-y-auto {
    overflow-y: auto;
  }
  </style>
  