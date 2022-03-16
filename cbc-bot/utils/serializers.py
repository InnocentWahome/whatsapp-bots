from rest_framework.relations import PrimaryKeyRelatedField


class RelatedField(PrimaryKeyRelatedField):
    def __init__(self, model, serializer, queryset=None):
        queryset = model.objects.all() if not queryset else queryset
        super().__init__(queryset=queryset)
        self.serializer = serializer
        self.model = model

    def to_representation(self, value):
        pk = value.pk
        if self.pk_field is not None:
            pk = self.pk_field.to_representation(value.pk)
        if not pk:
            return None
        return self.serializer(instance=self.model.objects.get(pk=pk)).data

