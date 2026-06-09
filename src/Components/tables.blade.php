<div class="flex-shrink-0 w-full h-full duration-300 ease-out opacity-0" wire:ignore.self
    x-data="{ 
        tables: @entangle('tables'),
        selectedTable: @entangle('table'),
        search: '',
        get filteredTables() {
            if(this.search != ''){
                return this.tables.filter(
                    i => i.toLowerCase().startsWith(this.search.toLowerCase())
                )
            }
            return this.tables;
        },
        tableCapitalized(table) {
            return table.charAt(0).toUpperCase() + table.slice(1);
        },
        selectTable(table) {
            this.selectedTable = table;
            Livewire.dispatch('selectTable', { table: table });
        }
    }"
    x-init="setTimeout(function(){ $el.classList.remove('opacity-0'); }, 10);">

    <div class="w-full h-auto">
        <div class="relative items-center hidden pb-1">
            <input placeholder="Search tables" @keydown.escape="search='';" x-ref="search" name="tables" type="text" size="sm" x-model="search" class="w-full px-0 bg-transparent border-0 border-b-2 border-transparent outline-none focus:border-b-2 hover:border-gray-900 active:border-gray-900 focus-within:border-gray-900 focus:outline-none active:outline-none focus:ring-0" />
            <button x-show="search!=''" @click="search=''; $refs.search.focus()" class="absolute right-0 flex items-center justify-center w-5 h-5 mr-0.5 leading-none text-gray-500 bg-gray-200 rounded-full" x-cloak>
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <ul class="space-y-2 text-lg">
            <template x-for="table in filteredTables">
                <li>
                    <button 
                        @click="selectTable(table)" 
                        class="flex items-center justify-start w-full duration-300 ease-out hover:pl-1 text-neutral-900/90 hover:text-neutral-900 group ">
                        <span class="relative">
                            <span x-text="tableCapitalized(table)"></span>
                            <span 
                                
                                :class="{'opacity-100 w-full left-0': selectedTable == table, 'opacity-0 w-0 left-0': selectedTable != table}"
                                class="absolute bottom-0 h-0.5 block duration-200 ease-out translate-y-px rounded-full bg-neutral-900"></span>
                        </span>

                    </button>
                </li>
            </template>
            <template x-if="!filteredTables.length">
                <li class="w-full text-xs text-center text-gray-500">No results found.
                    <button @click="search=''" class="text-blue-500 underline">Clear Search?</button>
                </li>
            </template>
        </ul>
    </div>
</div>