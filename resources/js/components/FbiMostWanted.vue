<template>
  <div class="p-6 bg-gray-100 min-h-screen flex flex-col items-center">
    <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">
      FBI Most Wanted
    </h1>

    <div class="mb-8 w-full max-w-3xl">
      <div class="bg-white rounded-md shadow-md p-4">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">
          Filter Your Search
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
          <div>
            <label
              for="title"
              class="block text-gray-600 text-sm font-bold mb-2"
              >Title/Description:</label
            >
            <input
              type="text"
              id="title"
              class="form-control form-control-sm"
              placeholder="Search by Title or Description"
              v-model="searchParams.title"
              @input="searchWanted"
            />
          </div>
          <div>
            <label
              for="aliases"
              class="block text-gray-600 text-sm font-bold mb-2"
              >Aliases:</label
            >
            <input
              type="text"
              id="aliases"
              class="form-control form-control-sm"
              placeholder="Comma-separated"
              v-model="searchParams.aliases"
              @input="searchWanted"
            />
          </div>
          <div>
            <label
              for="nationality"
              class="block text-gray-600 text-sm font-bold mb-2"
              >Nationality:</label
            >
            <input
              type="text"
              id="nationality"
              class="form-control form-control-sm"
              placeholder="Search by Nationality"
              v-model="searchParams.nationality"
              @input="searchWanted"
            />
          </div>
          <div>
            <label for="age" class="block text-gray-600 text-sm font-bold mb-2"
              >Age Range:</label
            >
            <div class="flex space-x-2">
              <input
                type="number"
                id="age"
                class="form-control form-control-sm"
                placeholder="Min"
                v-model.number="searchParams.age_min"
                @input="searchWanted"
              />
              <input
                type="number"
                class="form-control form-control-sm"
                placeholder="Max"
                v-model.number="searchParams.age_max"
                @input="searchWanted"
              />
            </div>
          </div>
          <div>
            <label
              for="height"
              class="block text-gray-600 text-sm font-bold mb-2"
              >Height Range (inches):</label
            >
            <div class="flex space-x-2">
              <input
                type="number"
                id="height"
                class="form-control form-control-sm"
                placeholder="Min"
                v-model.number="searchParams.height_min"
                @input="searchWanted"
              />
              <input
                type="number"
                class="form-control form-control-sm"
                placeholder="Max"
                v-model.number="searchParams.height_max"
                @input="searchWanted"
              />
            </div>
          </div>
          <div>
            <label
              for="weight"
              class="block text-gray-600 text-sm font-bold mb-2"
              >Weight:</label
            >
            <input
              type="text"
              id="weight"
              class="form-control form-control-sm"
              placeholder="Weight"
              v-model="searchParams.weight"
              @input="searchWanted"
            />
          </div>
          <div>
            <label for="eyes" class="block text-gray-600 text-sm font-bold mb-2"
              >Eyes Color:</label
            >
            <input
              type="text"
              id="eyes"
              class="form-control form-control-sm"
              placeholder="Eyes Color"
              v-model="searchParams.eyes"
              @input="searchWanted"
            />
          </div>
          <div>
            <label for="hair" class="block text-gray-600 text-sm font-bold mb-2"
              >Hair Color:</label
            >
            <input
              type="text"
              id="hair"
              class="form-control form-control-sm"
              placeholder="Hair Color"
              v-model="searchParams.hair"
              @input="searchWanted"
            />
          </div>
          <div>
            <label
              for="scars_and_marks"
              class="block text-gray-600 text-sm font-bold mb-2"
              >Scars/Marks:</label
            >
            <input
              type="text"
              id="scars_and_marks"
              class="form-control form-control-sm"
              placeholder="Scars and Marks"
              v-model="searchParams.scars_and_marks"
              @input="searchWanted"
            />
          </div>
          <div>
            <label
              for="locations"
              class="block text-gray-600 text-sm font-bold mb-2"
              >Locations:</label
            >
            <input
              type="text"
              id="locations"
              class="form-control form-control-sm"
              placeholder="Locations"
              v-model="searchParams.locations"
              @input="searchWanted"
            />
          </div>
          <div>
            <label
              for="status"
              class="block text-gray-600 text-sm font-bold mb-2"
              >Status:</label
            >
            <input
              type="text"
              id="status"
              class="form-control form-control-sm"
              placeholder="Status"
              v-model="searchParams.status"
              @input="searchWanted"
            />
          </div>
        </div>
        <button
          class="btn btn-outline-secondary btn-sm"
          type="button"
          @click="resetSearch"
        >
          Reset Filters
        </button>
      </div>
    </div>

    <div v-if="loading" class="text-center text-gray-500 text-lg">
      Loading...
    </div>
    <div v-if="error" class="text-center text-red-500 text-lg">{{ error }}</div>

    <div v-if="wantedList.length" class="container mt-5 text-center">
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 text-center">
        <div
          v-for="(person, index) in wantedList"
          :key="person.uid || index"
          class="col"
        >
          <div class="card h-100 card-wrapper" @click="openModal(person)">
            <img
              v-if="person.images && person.images.length > 0"
              :src="person.images[0].thumb"
              class="rounded mx-auto d-block"
              alt="thumbnail"
            />
            <div class="card-body text-center">
              <h5 class="card-title">{{ person.title }}</h5>
              <p class="card-text">{{ person.description }}</p>
            </div>
            <div class="mt-2">
              <p
                class="text-gray-600 text-sm"
                v-if="person.aliases && person.aliases.length > 0"
              >
                <strong>Aliases:</strong> {{ person.aliases.join(", ") }}
              </p>
              <p
                class="text-gray-600 text-sm"
                v-if="
                  person.dates_of_birth_used &&
                  person.dates_of_birth_used.length > 0
                "
              >
                <strong>DOB:</strong>
                {{ person.dates_of_birth_used.join(", ") }}
              </p>
              <p class="text-gray-600 text-sm" v-if="person.nationality">
                <strong>Nationality:</strong> {{ person.nationality }}
              </p>
            </div>
            <div class="card-footer bg-transparent border-top">
              <small class="text-muted">{{ person.uid || "N/A" }}</small>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      v-else-if="!loading && !error"
      class="text-center text-gray-500 text-lg"
    >
      No results found.
    </div>

    <nav v-if="totalPages > 1" class="mt-8">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <button class="page-link" @click="changePage(currentPage - 1)">
            Previous
          </button>
        </li>

        <li
          v-for="page in visiblePageNumbers"
          :key="page"
          class="page-item"
          :class="{ active: currentPage === page }"
        >
          <button class="page-link" @click="changePage(page)">
            {{ page }}
          </button>
        </li>

        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <button class="page-link" @click="changePage(currentPage + 1)">
            Next
          </button>
        </li>
      </ul>
    </nav>

    <div
      class="modal fade"
      id="cardModal"
      tabindex="-1"
      aria-labelledby="cardModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCardTitle">
              {{ modalCard.reward_text || modalCard.title }}
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body" id="modalCardText">
            <div class="row">
              <div class="col-md-4 text-center">
                <img
                  v-if="modalCard.images && modalCard.images.length > 0"
                  :src="modalCard.images[0].original"
                  alt="Full Image"
                  class="img-fluid rounded shadow-md mb-3"
                />
              </div>
              <div class="col-md-8">
                <p v-if="modalCard.status">
                  <strong>Status:</strong> {{ modalCard.status }}
                </p>
                <p v-if="modalCard.description">
                  <strong>Description:</strong> {{ modalCard.description }}
                </p>
                <p v-if="modalCard.reward_text">
                  <strong>Reward:</strong> {{ modalCard.reward_text }}
                </p>
                <p v-if="modalCard.aliases && modalCard.aliases.length > 0">
                  <strong>Aliases:</strong> {{ modalCard.aliases.join(", ") }}
                </p>
                <p
                  v-if="
                    modalCard.dates_of_birth_used &&
                    modalCard.dates_of_birth_used.length > 0
                  "
                >
                  <strong>DOB:</strong>
                  {{ modalCard.dates_of_birth_used.join(", ") }}
                </p>
                <p v-if="modalCard.nationality">
                  <strong>Nationality:</strong> {{ modalCard.nationality }}
                </p>
                <p v-if="modalCard.age_min || modalCard.age_max">
                  <strong>Age:</strong>
                  <span v-if="modalCard.age_min">{{ modalCard.age_min }}</span>
                  <span v-if="modalCard.age_min && modalCard.age_max">-</span>
                  <span v-if="modalCard.age_max">{{ modalCard.age_max }}</span>
                </p>
                <p v-if="modalCard.height_min || modalCard.height_max">
                  <strong>Height:</strong>
                  <span v-if="modalCard.height_min">{{
                    modalCard.height_min
                  }}</span>
                  <span v-if="modalCard.height_min && modalCard.height_max"
                    >-</span
                  >
                  <span v-if="modalCard.height_max"
                    >{{ modalCard.height_max }} inches</span
                  >
                </p>
                <p v-if="modalCard.weight">
                  <strong>Weight:</strong> {{ modalCard.weight }}
                </p>
                <p v-if="modalCard.eyes">
                  <strong>Eyes:</strong> {{ modalCard.eyes }}
                </p>
                <p v-if="modalCard.hair">
                  <strong>Hair:</strong> {{ modalCard.hair }}
                </p>
                <p v-if="modalCard.scars_and_marks">
                  <strong>Scars/Marks:</strong> {{ modalCard.scars_and_marks }}
                </p>
                <p v-if="modalCard.locations">
                  <strong>Locations:</strong> {{ modalCard.locations }}
                </p>
                <div
                  v-if="modalCard.files && modalCard.files.length > 0"
                  class="mt-3"
                >
                  <strong>Additional Files:</strong>
                  <ul>
                    <li v-for="(file, index) in modalCard.files" :key="index">
                      <a :href="file.url" target="_blank">{{ file.name }}</a>
                    </li>
                  </ul>
                </div>
                <p v-if="modalCard.url" class="mt-3">
                  <strong>More Info:</strong>
                  <a :href="modalCard.url" target="_blank">View Details</a>
                </p>
              </div>
            </div>
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
</template>
  <script>
import { ref, reactive, onMounted, watch, computed } from "vue";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import axios from "axios"; // Import Axios

export default {
  name: "FBIMostWanted",
  setup() {
    const wantedList = ref([]);
    const loading = ref(false);
    const error = ref(null);
    const modalCard = ref({});
    const cardModal = ref(null);
    const searchParams = reactive({
      title: null,
      aliases: null,
      nationality: null,
      age_min: null,
      age_max: null,
      height_min: null,
      height_max: null,
      weight: null,
      eyes: null,
      hair: null,
      scars_and_marks: null,
      locations: null,
      status: null,
      page: 1, // Default page
    });
    const totalPages = ref(1);
    const currentPage = ref(1);
    const itemsPerPage = ref(9); // You can make this configurable if needed
    const visiblePageRange = 5; // Number of page links to show

    const openModal = (person) => {
      modalCard.value = { ...person };
      const modalElement = document.getElementById("cardModal");
      if (modalElement) {
        cardModal.value = new bootstrap.Modal(modalElement);
        cardModal.value.show();
      }
    };

    const fetchWanted = async (params = {}) => {
      loading.value = true;
      error.value = null;
      try {
        const response = await axios.get("/api/wanted", { params });
        if (!response.data.error && response.data.data) {
          wantedList.value = response.data.data;
          totalPages.value = Math.ceil(
            response.data.total / itemsPerPage.value
          );
        } else {
          error.value =
            response.data.message || "An error occurred while fetching data.";
          wantedList.value = [];
          totalPages.value = 1;
        }
      } catch (err) {
        console.error(err);
        error.value = "Failed to load data.";
        wantedList.value = [];
        totalPages.value = 1;
      } finally {
        loading.value = false;
      }
    };

    const searchWanted = () => {
      currentPage.value = 1; // Reset to first page on new search
      searchParams.page = 1;
      const params = { ...searchParams };
      fetchWanted(params);
    };

    const resetSearch = () => {
      for (const key in searchParams) {
        searchParams[key] = null;
      }
      currentPage.value = 1;
      searchParams.page = 1;
      fetchWanted();
    };

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value && page !== currentPage.value) {
        currentPage.value = page;
        searchParams.page = page;
        fetchWanted({ ...searchParams });
      }
    };

    const visiblePageNumbers = computed(() => {
      const start = Math.max(
        1,
        currentPage.value - Math.floor(visiblePageRange / 2)
      );
      const end = Math.min(totalPages.value, start + visiblePageRange - 1);
      const pages = [];
      for (let i = start; i <= end; i++) {
        pages.push(i);
      }
      return pages;
    });

    onMounted(() => {
      fetchWanted({ page: currentPage.value }); // Initial load with default page 1
    });

    // Watch for changes in searchParams (except page) to trigger search
    watch(
      () => ({ ...searchParams, page: null }), // Exclude page from the watch
      () => {
        searchWanted();
      },
      { deep: true }
    );

    return {
      wantedList,
      loading,
      error,
      modalCard,
      openModal,
      searchParams,
      searchWanted,
      resetSearch,
      totalPages,
      currentPage,
      changePage,
      visiblePageNumbers,
    };
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
  min-height: 150px;
}
</style>
