<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">List User Example</div>

                    <div class="card-body">
                        <ul id="example-1">
                            <li v-for="item in users" :key="item.id">
                                {{ item.name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        users: Array
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
