
<template>
    <div class="p-6 bg-gray-100 min-h-screen flex flex-col items-center">
      <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">
        FBI Most Wanted
      </h1>

      <div v-if="loading" class="text-center text-gray-500 text-lg">
        Loading...
      </div>
      <div v-if="error" class="text-center text-red-500 text-lg">{{ error }}</div>

      <div v-if="wantedList.length" class="container mt-5 text-center">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 text-center">
          <div v-for="(person, index) in wantedList" :key="index" class="col">
            <div class="card h-100 card-wrapper" @click="openModal(person)">
              <img
                :src="person.images[0].thumb"
                class="rounded mx-auto d-block"
                alt="thumbnail"
              />
              <div class="card-body text-center">
                <h5 class="card-title">{{ person.title }}</h5>
                <p class="card-text">{{ person.description }}</p>
              </div>
              <div class="mt-2">
                  <p class="text-gray-600 text-sm" v-if="person.aliases">
                    <strong>Aliases:</strong> {{ person.aliases.join(", ") }}
                  </p>
                  <p
                    class="text-gray-600 text-sm"
                    v-if="person.dates_of_birth_used"
                  >
                    <strong>DOB:</strong>
                    {{ person.dates_of_birth_used.join(", ") }}
                  </p>
                  <p class="text-gray-600 text-sm" v-if="person.nationality">
                    <strong>Nationality:</strong> {{ person.nationality }}
                  </p>
                </div>
              <div class="card-footer bg-transparent border-top">
                <small class="text-muted">kl34k3j4</small>
              </div>
            </div>
          </div>

          <div
            class="modal fade"
            id="cardModal"
            tabindex="-1"
            aria-labelledby="cardModalLabel"
            aria-hidden="true"
          >
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCardTitle">
                    {{ modalCard.reward_text }}
                  </h5>
                  <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                  ></button>
                </div>
                <div class="modal-body" id="modalCardText">
                  {{ modalCard.status }}
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                  >
                    Close
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- <div v-if="wantedList.length" class="container mt-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
          <div v-for="(person, index) in wantedList" :key="index" class="col">
            <div class="card h-100 card-wrapper">
              <div v-if="person.images?.length" class="mt-3">
                <ul class="list-disc ml-5">
                </ul>
              </div>

              <img
                :src="person.images[0].thumb"
                class="rounded mx-auto d-block"
                alt=""
                srcset=""
              />
              <div class="card-body">
                <h5 class="card-title">{{ person.title }}</h5>
                <p class="card-text">
                  {{ person.description }}
                </p>
                <div class="mt-2">
                  <p class="text-gray-600 text-sm" v-if="person.aliases">
                    <strong>Aliases:</strong> {{ person.aliases.join(", ") }}
                  </p>
                  <p
                    class="text-gray-600 text-sm"
                    v-if="person.dates_of_birth_used"
                  >
                    <strong>DOB:</strong>
                    {{ person.dates_of_birth_used.join(", ") }}
                  </p>
                  <p class="text-gray-600 text-sm" v-if="person.nationality">
                    <strong>Nationality:</strong> {{ person.nationality }}
                  </p>
                </div>
                <a href="#" class="btn btn-primary">View Details</a>
              </div>
            </div>
          </div>
        </div>
      </div> -->

      <!-- <div v-if="wantedList.length" class="w-full max-w-7xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 row">
          <transition-group name="fade" tag="div">
            <div
              v-for="(person, index) in wantedList"
              :key="index"
              class="bg-white p-5 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 col"
            >
              <h2 class="text-xl font-semibold text-gray-800 mb-2">
                {{ person.title }}
              </h2>
              <p class="text-gray-700 text-sm mb-2">
                <strong>Description:</strong> {{ person.description }}
              </p>
              <p class="text-gray-900 font-semibold" v-if="person.reward_text">
                💰 {{ person.reward_text }}
              </p>

              <div class="mt-2">
                <p class="text-gray-600 text-sm" v-if="person.aliases">
                  <strong>Aliases:</strong> {{ person.aliases.join(", ") }}
                </p>
                <p
                  class="text-gray-600 text-sm"
                  v-if="person.dates_of_birth_used"
                >
                  <strong>DOB:</strong>
                  {{ person.dates_of_birth_used.join(", ") }}
                </p>
                <p class="text-gray-600 text-sm" v-if="person.nationality">
                  <strong>Nationality:</strong> {{ person.nationality }}
                </p>
              </div>

              <div class="flex justify-between mt-4 text-gray-500">
                <p v-if="person.height_min || person.height_max">
                  📏 {{ person.height_min }} - {{ person.height_max }} in
                </p>
                <p v-if="person.weight">⚖️ {{ person.weight }}</p>
              </div>

              <div class="mt-3">
                <p class="text-gray-600 text-sm" v-if="person.scars_and_marks">
                  <strong>Scars/Marks:</strong> {{ person.scars_and_marks }}
                </p>
              </div>

              <div v-if="person.files?.length" class="mt-3">
                <p class="font-semibold">🔗 Files:</p>
                <ul class="list-disc ml-5">
                  <li v-for="(file, i) in person.files" :key="i">
                    <a
                      :href="file.url"
                      class="text-blue-500 hover:text-blue-700 underline"
                      target="_blank"
                    >
                      {{ file.name }}
                    </a>
                  </li>
                </ul>
              </div>

              <div class="mt-4">
                <a
                  :href="person.url"
                  target="_blank"
                  class="text-sm text-white bg-blue-600 px-3 py-2 rounded-lg hover:bg-blue-700 transition"
                >
                  More Info →
                </a>
              </div>
            </div>
          </transition-group>
        </div>
      </div> -->
    </div>
  </template>

    <script>
  import { ref } from "vue";
  import 'bootstrap/dist/css/bootstrap.min.css';
  import 'bootstrap/dist/js/bootstrap.bundle.min.js';

  export default {
    name: "FBIMostWanted",
    data() {
      return {
        wantedList: [],
        loading: false,
        error: null,
      };
    },
    setup() {
      const modalCard = ref({
      reward_text: "",
      status: "",
      });

      const cardModal = ref(null);

      const openModal = (person) => {
        modalCard.value = { ...person };
        const modalElement = document.getElementById("cardModal");
        if (modalElement) {
          cardModal.value = new bootstrap.Modal(modalElement);
          cardModal.value.show();
        }
      };

      return {
        modalCard,
        openModal,
      };
    },
    methods: {
      async fetchMostWanted() {
        this.loading = true;
        this.error = null;

        try {
          const response = await fetch("/api/wanted");
          const result = await response.json();

          if (!result.error && result.data) {
            this.wantedList = result.data;
          } else {
            this.error =
              result.message || "An error occurred while fetching data.";
          }
        } catch (err) {
          console.error(err);
          this.error = "Failed to load data.";
        } finally {
          this.loading = false;
        }
      },
    },
    mounted() {
      this.fetchMostWanted();
    },
  };
  </script>
  <style scoped>
  .card-wrapper {
    border-radius: 0.5rem;
    overflow: hidden;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    cursor: pointer;
  }
  .card-wrapper:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  }
  .card-title {
    color: #333;
  }
  .card-text {
    color: #666;
  }
  .card-body {
    display: flex;
    flex-direction: column;
    min-height: 150px; /* Adjust as needed */
  }
  </style>
