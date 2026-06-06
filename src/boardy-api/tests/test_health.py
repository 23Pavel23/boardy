import requests

def test_health_endpoint_returns_ok():
    response = requests.get("http://localhost:8000/health")
    assert response.status_code == 200
    assert response.json() == {"ok": True}
