PokemonDetail = Backbone.View.extend({

    events : {
        'input .info-group' : 'calculator',
        'input .level' : 'recalculator',
        'change .nature-select' : 'nature'
    },

    calculator : function(event) {
        var self = this.$el;
        var _this = $(event.target);
        var ability = _this.parents('tr');
        var level = parseInt(self.find('.level').val(), 10),
            base = parseInt(ability.find('.base').val(), 10),
            ivs = parseInt(ability.find('.ivs').val(), 10),
            evs = parseInt(ability.find('.evs').val(), 10),
            total = parseInt(ability.find('.total').html(), 10),
            rate = parseInt(ability.find('.boost').val(), 10);
        rate = rate >= 0? (2+rate)/2 : 2/(2-rate);
        if(ability.hasClass('hp')) {
            total = parseInt(((base*2+ivs+evs/4)*level/100+10+level), 10);
        } else {
            total = parseInt(((base*2+ivs+evs/4)*level/100+5) * rate, 10);
        }
        ability.find('.total').html(total);
    },

    recalculator : function() {
        $('.evs').trigger('input');
    },

    nature : function() {
        
    }
    //根据性格判断倍率
    // getRateByNature : function(tar,nature){
    //     var na=1;
    //     //nature中的1-5代表五维
    //     switch(tar){
    //         case'.at': if(nature[0]==1){
    //             na=1.1;
    //         }else if(nature[1]==1){
    //             na=0.9;
    //         }
    //         break;
    //         case'.df': if(nature[0]==2){
    //             na=1.1;
    //         }else if(nature[1]==2){
    //             na=0.9;
    //         }
    //         break;
    //         case'.sa': if(nature[0]==3){
    //             na=1.1;
    //         }else if(nature[1]==3){
    //             na=0.9;
    //         }
    //         break;
    //         case'.sd': if(nature[0]==4){
    //             na=1.1;
    //         }else if(nature[1]==4){
    //             na=0.9;
    //         }
    //         break;
    //         case'.sp': if(nature[0]==5){
    //             na=1.1;
    //         }else if(nature[1]==5){
    //             na=0.9;
    //         }
    //         break;
    //     }
    //     return na;
    // }
});