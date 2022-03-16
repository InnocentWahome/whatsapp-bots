from django.core.paginator import Paginator
from django.db.models import QuerySet


def paginate_queryset(qs: QuerySet, page_size, page_number):
    """ This funtion is the one we will use to search and paginate products
    Arguments:
        qs - the campaigns query set to be filtered
        query -  the query if available
        number - the number of items
        last_item - the position of the last item on the list
    """
    if page_size == 0:
        return qs.none()
    paginator = Paginator(qs, page_size, 5)
    return paginator.get_page(page_number)
