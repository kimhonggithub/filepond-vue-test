<script>
export default {
  props: {
    data: {
      type: Array,
      required: true,
    },
  
  },
  methods: {
    getFileUrl(path) {
      return '/storage/images/' + path;
    },
  },
};
</script>

<template>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
        <!-- table -->
        <table class="table-fixed w-full posts-table">
          <thead>
            <tr class="bg-gray-100">
              <th class="px-4 py-2 w-20">No.</th>
              <th class="px-4 py-2">Title</th>
              <th class="px-4 py-2">Des</th>
              <th class="px-4 py-2">FileName</th>
              <th class="px-4 py-2">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in data" :key="item.id">
              <td class="px-4 py-2 border">{{ item.id }}</td>
              <td class="px-4 py-2 border">{{ item.post.title }}</td>
              <td class="px-4 py-2 border">{{ item.post.description }}</td>
              <td class="px-4 py-2 border">
                <a :href="getFileUrl(item.path)" target="_blank">{{
                  item.name
                }}</a>
              </td>

              <td class="border px-4 py-2">
                <button
                  @click="openForm(item)"
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                >
                  Edit
                </button>
                <button
                  @click="deleteItem(item)"
                  class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>