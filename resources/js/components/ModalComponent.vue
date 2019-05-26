<template>
    <div>
        <button type="button" class="btn" v-bind:class="btnColor" data-toggle="modal" :data-target="'#modalCenter-'+idName" v-on:click="emitClick">{{ buttonText }}</button>

        <div class="modal fade" :id="'modalCenter-'+idName" tabindex="-1" role="dialog" :aria-labelledby="'modalCenterTitle'+idName" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" :id="'modalLongTitle'+idName">{{ headTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="emitCancel">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="emitCancel">Close</button>
                    <button type="button" class="btn btn-primary" v-bind:data-dismiss="isDismiss" v-on:click="emitConfirm">{{ okText }}</button>
                </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: {
        headTitle: String,
        buttonText: String,
        okText: String,
        btnColor: String,
        idName: String
        },
    data(){
        return {
            isDismiss:false
        }
    },
    methods: {
        emitCancel(){
            this.$emit('onCancel');
        },
        emitConfirm(){
            this.$emit('onConfirm');
            this.isDismiss="modal";
        },
        emitClick(){
            this.$emit('onClick');
        }
    },
    mounted(){
        console.log("ModalComponent mount.");
    } 
}
</script>
