<template>
  <div>
    <v-row v-if="cardView">
      CARD VIEW
    </v-row>
    <v-card v-else rounded="lg">
      <v-toolbar flat>
        <v-badge :content="total | bigNumber" @click="selectAll">
          <v-toolbar-title class="text-capitalize">{{ title }}</v-toolbar-title>
          <v-btn
            slot="badge"
            text
            rounded
            dark
            class="mt-n2 mx-n3"
            small
            @click="selectAll"
          >
            {{ total | bigNumber }}
          </v-btn>
        </v-badge>

        <v-spacer />
        <v-text-field
          v-model="query.q"
          label="Search..."
          :rounded="!searchFocused"
          prepend-inner-icon="mdi-magnify"
          hide-details
          clearable
          @focus="searchFocused = true"
          @blur="searchFocused = false"
          @keyup="onSearchKeyup"
          @click:clear="onSearchKeyup"
        />

        <v-btn icon v-if="filters" @click="isFilters = !isFilters">
          <v-icon>mdi-filter</v-icon>
        </v-btn>

        <v-btn :loading="refreshing" icon class="mx-2" @click="refresh">
          <v-icon>mdi-refresh</v-icon>
        </v-btn>
        <slot name="add-new-btn">
          <v-btn class="ml-4" outlined color="primary" @click="create = true"
            >Add New</v-btn
          >
        </slot>
      </v-toolbar>

      <v-expand-transition>
        <div v-if="isFilters" class="px-4">
          <slot name="filters" />
        </div>
      </v-expand-transition>

      <v-expand-transition>
        <v-row v-if="selected.length || isQuickSelectAll" no-gutters>
          <v-chip
            class="ml-4 mt-2"
            tile
            color="success"
            close
            loading
            @click:close="deselectAll"
          >
            {{ selectedCount | bigNumber }} selected
          </v-chip>

          <slot
            name="selected-actions"
            :selected="selected"
            :is-select-all="isQuickSelectAll"
            :total="total"
            :form="getForm"
          />
        </v-row>
      </v-expand-transition>

      <v-card-text>
        <v-data-table
          v-model="selected"
          :headers="getHeaders"
          :items="items"
          :loading="loading || selectingAll"
          :page.sync="query.page"
          :items-per-page="query.limit"
          :show-select="items.length > 0 && canSelect"
          :sort-by.sync="query.orderby"
          :sort-desc.sync="sortDesc"
          :server-items-length="total"
          :options.sync="options"
          hide-default-footer
          @page-count="onPageCount"
        >
          <template v-slot:[`header.data-table-select`]="{}">
            <v-checkbox
              v-model="isQuickSelectAll"
              checked
              readonlyx
              @change="selectingAll = false"
              color="grey darken-4"
            />
          </template>
          <template
            v-if="isQuickSelectAll"
            v-slot:[`item.data-table-select`]="{}"
          >
            <v-checkbox
              v-model="isQuickSelectAll"
              checked
              readonlyx
              color="grey darken-4"
              @click="isQuickSelectAll = false"
            />
          </template>

          <template
            v-for="name in itemSlots"
            :slot="`item.${name}`"
            slot-scope="{ item }"
          >
            <div :key="`customSlots${name}`">
              <slot :name="`item-slot-${name}`" :item="item" />
            </div>
          </template>

          <template
            v-for="primaryCol in linkCols"
            v-slot:[`item.${primaryCol}`]="{ item }"
          >
            <v-btn
              :key="`primaryCol${primaryCol}`"
              text
              class="text-none"
              color="primary"
              @click="onSelect(item)"
            >
              <span class="mx-n4">
                {{ item[primaryCol] }}
              </span>
            </v-btn>
          </template>

          <!-- Active  -->
          <template v-slot:[`item.active`]="{ item }">
            <v-switch
              label="Active"
              v-model="item.active"
              :loading="activatingId == item.id"
              @change="onItemActive(item.id, $event)"
            />
          </template>

          <!-- Actions  -->
          <template v-slot:[`item.actions`]="{ item }">
            <template v-if="deleteId == item.id">
              <v-btn small color="error" :loading="deleting" @click="deleteItem"
                >Delete</v-btn
              >
              <v-btn small depressed class="ml-1" @click="deleteId = null"
                >Cancel</v-btn
              >
            </template>
            <template v-else>
              <v-tooltip v-for="action in actions" :key="action.value" top>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    v-bind="attrs"
                    v-on="on"
                    icon
                    @click="onAction(action.value, item)"
                  >
                    <v-icon>{{ action.icon }}</v-icon>
                  </v-btn>
                </template>
                <span>{{ action.text }}</span>
              </v-tooltip>
            </template>
          </template>

          <!-- Footer  -->
          <template slot="footer">
            <v-expand-transition>
              <div v-if="activeSelected.length" class="pt-4 pb-2">
                <slot name="group-actions" :selected="activeSelected">
                  <v-row align="center" justify="start" class="my-4" no-gutters>
                    <v-row
                      v-if="isSelectedDelete"
                      no-gutters
                      align="center"
                      justify="start"
                    >
                      <v-btn
                        color="error"
                        :loading="deletingSelected"
                        @click="deleteSelected"
                        >Delete Selected</v-btn
                      >
                      <v-btn
                        class="ml-1"
                        depressed
                        @click="isSelectedDelete = false"
                        >Cancel</v-btn
                      >
                    </v-row>
                    <template v-else>
                      <v-tooltip
                        v-for="action in groupActions"
                        :key="`se${action.value}`"
                        top
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-btn
                            v-bind="attrs"
                            v-on="on"
                            icon
                            @click="action.selectedClick"
                          >
                            <v-icon>{{ action.icon }}</v-icon>
                          </v-btn>
                        </template>
                        <span>{{ action.text }} Selected</span>
                      </v-tooltip>
                    </template>
                  </v-row>
                </slot>
              </div>
            </v-expand-transition>
          </template>
        </v-data-table>

        <v-row no-gutters align="center" justify="space-between" class="my-4">
          <v-pagination
            v-model="query.page"
            :length="query.pages"
            :disabled="loading"
            total-visible="9"
            @input="getItems($event)"
          ></v-pagination>
          <div style="width: 100px">
            <v-select
              v-model="query.limit"
              solo
              dense
              hide-details
              :items="rowItems"
              :disabled="loading"
              @input="onRowItems"
            />
          </div>
        </v-row>
      </v-card-text>
    </v-card>

    <v-dialog v-model="create" persistent width="550">
      <slot name="create-form">
        <m-form
          create
          can-close
          autofocus
          :endpoint="endpoint"
          :form="createForm"
          @created="onCreated"
          @close="create = false"
        />
      </slot>
    </v-dialog>

    <v-dialog v-model="edit" persistent width="550">
      <slot name="edit-form">
        <m-form
          v-if="edit"
          v-model="editItem"
          can-close
          :endpoint="`${endpoint}/${editItem.id}`"
          :fields="form ? form.fields : fields"
          :title="form ? form.title : ''"
          @input="onEdited"
          @close="edit = false"
        />
      </slot>
    </v-dialog>
  </div>
</template>

<script>
  import js from './js'
  export default js
</script>
