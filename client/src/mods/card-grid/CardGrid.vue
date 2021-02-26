<template>
  <card-grid-layout v-show="!hideAll">
    <v-toolbar slot="toolbar" flat>
      <card-grid-search
        v-model="params.q"
        v-bind="searchAttrs"
        v-on="onSearch"
      />
      <v-spacer />
      <slot name="toolbar-content" />
      <span class="grey--text text--darken-2 ml-8"
        >{{ items.length }} of {{ pagin.total }}</span
      >
    </v-toolbar>

    <v-row align="start" justify="center" no-gutters>
      <div v-for="item in items" :key="item.id" :class="`mb-${mb} mx-${mx}`">
        <slot name="card" v-bind="{ item }">
          <card-grid-card
            v-bind="cardAttrs"
            :item="item"
            :deleting="deletingCard == item.id"
            v-on="onCard"
          >
            <v-hover v-slot="{ hover }">
              <div>
                <slot name="card-content" v-bind="{ item }">
                  <v-card
                    height="200"
                    color="grey lighten-3"
                    :class="hover ? '' : 'card-grid-filter-bw'"
                    flat
                    tile
                    @click="selectCard(item.id)"
                  >
                    <v-img
                      v-if="item.image"
                      :src="item.image"
                      height="200"
                    ></v-img>
                    <v-row
                      v-else
                      align="center"
                      justify="center"
                      style="height:100%"
                    >
                      <m-logo size="80" opacity="0.3" force-color="white" />
                    </v-row>
                  </v-card>
                  <v-card-title v-text="item.name || item.title" />
                </slot>
              </div>
            </v-hover>
          </card-grid-card>
        </slot>
      </div>
    </v-row>

    <v-pagination
      v-model="params.page"
      :length="pagin.pages"
      @input="onPagin"
    />
  </card-grid-layout>
</template>

<script>
  import cardGrid from './card-grid'
  export default cardGrid
</script>

<style scoped>
  .card-grid-filter-bw {
    filter: grayscale(100%);
  }
</style>
